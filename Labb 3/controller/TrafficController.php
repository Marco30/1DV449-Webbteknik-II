<?php

require_once("./view/TrafficView.php");



class TrafficController {

	private $trafficView;

	public function __construct()
	{

		$this->trafficView = new TrafficView();
	}

	public function doControll()
	{

		return $this->trafficView->showStartPage();

	}
}