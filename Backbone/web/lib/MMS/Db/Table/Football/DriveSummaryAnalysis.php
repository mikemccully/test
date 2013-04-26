<?php
require_once '/MMS/Db/Table/Abstract.php';

class MMS_Db_Table_Football_DriveSummaryAnalysis extends MMS_Db_Table_Abstract
{
	protected $_name = 'DriveSummaryAnalysis';
	protected $_primary = 'DriveSummaryAnalysisId';

	/**
	 * (non-PHPdoc)
	 * @see Zend_Db_Table_Abstract::insert()
	 * 
	 * Check to see if this is a duplicate before we perform the insert. If 
	 * the DriveSummaryId is not present, the we will return false. This is the 
	 * column used to determine the duplicate status. Otherwise, we will 
	 * return the PK.
	 */
	public function insert( $data )
	{
		$pk	= false;
		// Check if it is a duplicate.
		if ( isset($data['DriveSummaryId']) )
		{
			$driveId	= $data['DriveSummaryId'];
			$where		= "DriveSummaryId={$driveId}";
			$row		= $this->fetchRow( $where );
			
			/*
			 * If the rows does not exist, then we will insert it, otherwise, 
			 * we will pull the PK from the existing row.
			 */
			if ( !$row )
			{
				$pk	= parent::insert( $data );
			}
			else 
			{
				$pk = $row->DriveSummaryAnalysisId;
			}
		}
		return $pk;
	}
}