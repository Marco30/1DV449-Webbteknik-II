<?php

require_once("SRadioModel.php");

$SR = new SRadioModel();

if($_GET['action'] == "getLatest")
{
	echo $SR->NewCallOrUseCache();
}