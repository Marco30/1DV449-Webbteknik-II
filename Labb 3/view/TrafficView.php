<?php


// Genererar HTML tagarna visar menyn i sidan

class TrafficView {

	public function showStartPage() {

		$ret = "

<div class='row'>
	<div class='col-md-6'>
		<div id='map-canvas'></div>
	</div>

	<div id='meny' class='col-md-4'>
		<h1>Trafik Idag</h1>

		<div id='categories'>
			<div id='Alla kategorier'>
				<a href='#'>Alla kategorier</a>
			</div>
			<div  id='Vägtrafik'>
				<a href='#'>Vägtrafik</a>
			</div>
			<div id='Kollektivtrafik'>
				<a href='#'>Kollektivtrafik</a>
			</div>
			<div id='Planerad störning'>
				<a href='#'>Planerat störning</a>
			</div>
			<div id='Övrigt'>
				<a href='#'>Övrigt</a>
			</div>
		</div>
		<div id='latestInfo'>
			<h4>Senaste trafikinformationen</h4>
			<ul id='eventsList'>
			</ul>
		</div>
	</div>
</div>

		";

		return $ret;
	}
}