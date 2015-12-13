<?php
//ladar in min classer jag ska använda i min applikation
	require_once("view/LayoutView.php");
	require_once("controller/TrafficController.php");

	session_start();// session startas

	$trafficController = new TrafficController();// skapar ett Controller objekt

	$htmlBody = $trafficController->doControll();// kör min doControll funktion i Controller klassen

	$view = new LayoutView(); // skapar ett HTMLView

	$view->ShowHTML($htmlBody);// kör min showHTML funktion i klassen LayoutView