<?php

class MMS_Model_DriveSummaryAnalysis
{
	public $DriveSummaryAnalysisId;
	public $DriveSummaryId;
	public $TeamId;
	public $BeginSide;
	public $BeginYard;
	public $IsValueDrive;
	public $Points;
	
	const BEGIN_SIDE_OWN		= 'own';
	const BEGIN_SIDE_OPPONENT	= 'opponent';
}