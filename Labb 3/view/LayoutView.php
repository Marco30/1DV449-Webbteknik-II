<?php

// Genererar HTML  tagarna som ska visas sidan

class LayoutView
{

	public function ShowHTML($body)
	{

		if($body === null)
		{
			throw new Exception();
		}
		/*
                laddar in minifierad bootstrap från extern plats
                laddar in externa minifierad JavaScript library-
                laddar googel maps api
         */
		echo "
		<!DOCTYPE html>
		<html>
			<head>
				<title>Trafik-siten!</title>
				<meta http-equiv='content-type' content='text/html; charset=utf-8'>
				<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='css/styles.css'>

			</head>
			<body>
				<div class='container' style='height:100%'>
					$body
				</div>
				<script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
                <script src='//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
				<script src='js/TrafficInfoData.js'></script>
				<script src='js/TrafficInfoBoard.js'></script>

                <script type='text/javascript'src='https://maps.googleapis.com/maps/api/js?key=AIzaSyBEDlMMz5VeW228J7_WwMDRlIn3ZektHPY'>
				</script>

			</body>
			</html>
		";
	}
}