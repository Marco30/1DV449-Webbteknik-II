<?php

require_once('CURLrequest.php');
require_once('GetStartPageInfo.php');
require_once('GetCalendarsInfo.php');
require_once('GetMovieInfo.php');
require_once('CrawlerView.php');
require_once('LayoutView.php');

require_once('CrawlerController.php');

//$url = 'http://localhost:8080/';

$CrawlerView = new CrawlerView();

$LayoutView = new LayoutView();

$CrawlerController = new CrawlerController($CrawlerView);

$CrawlerController->MyCrawlerController();

$HTML = $CrawlerController->getHTML();

$LayoutView->showHTML($HTML);
