<?php

require_once('view/DateTimeView.php');

// Genererar HTML tagarna som visar visar menyn och informatione i sidan

class TrafficView {

	public function showStartPage()
	{

// kl finns vet bara inte var jag kan lägga den i layouten
// $dtv = new DateTimeView();
// läg till tag i HTML så läggs klockan till
// " . $dtv->show() . "

		$ret = "

<div class='row'>

	<div id='Idag'>
				<h1>Trafik Idag</h1>
			</div>

	<div class='col-md-6'>
		<div id='map-canvas'></div>
	</div>

	<div id='meny' class='col-md-4'>
		<div id='categories'>
			<div id='Alla'>
				<a href='#'>Alla kategorier</a>
			</div>
			<div  id='Vegtrafik'>
				<a href='#'>Vägtrafik</a>
			</div>
			<div id='Kollektivtrafik'>
				<a href='#'>Kollektivtrafik</a>
			</div>
			<div id='Planerad'>
				<a href='#'>Planerat störning</a>
			</div>
			<div id='ovrigt'>
				<a href='#'>Övrigt</a>
			</div>
		</div>
		<div id='latestInfo'>
			<h4>Senaste Informationen</h4>
			<ul id='eventsList'>
			</ul>
		</div>
	</div>
</div>

		";

		return $ret;
	}
}