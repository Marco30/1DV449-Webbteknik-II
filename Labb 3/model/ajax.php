<?php

require_once("SRadioModel.php");

$srApiHandler = new SRadioModel();

if($_GET['action'] == "getLatest")
{
	echo $srApiHandler->NewCallOrUseCache();
}