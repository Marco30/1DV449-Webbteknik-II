<?php

//Marco villegas
// Använde error koden för att fel ikoden skulle visas
/*error_reporting(E_ALL);
ini_set('display_errors', 'On');*/

//ladar in min classer jag ska använda i min applikation
require_once('controller/CrawlerController.php');
require_once('view/LayoutView.php');
require_once('view/CrawlerView.php');


$LayoutView = new LayoutView();// skapar ett HTMLView
$CrawlerController = new CrawlerController();// skapar ett Controller objekt
$HTML = $CrawlerController->MyCrawlerController();// kör min MyCrawlerController funktion i Controller klassen
$LayoutView->showHTML($HTML);// kör min showHTML funktion i klassen LayoutView
