<?php
//Marco villegas
class DateTimeView
{

	public function show() 
	{
        //EN
        /*date_default_timezone_set("Europe/Stockholm");// Sätter vilken tidszon vi är i
		setlocale(LC_TIME, 'swedish');// sätter klockan till svensktid
		$time = date('l, \t\h\e jS \o\f F Y, \T\h\e \t\i\m\e \i\s H:i:s');//ger oss datum månad och tid */

		//SV
		setlocale(LC_ALL, "sv_SE", "sv_SE.utf-8", "sv", "swedish"); // Sätter vilken tidszon vi är i
		$time = ucwords(utf8_encode(strftime("%A"))) . " den " . date("j") . " ".  strftime("%B") . " &aring;r " . strftime("%Y") . ". Klockan &auml;r [" . date("H:i:s") . "].";//ger oss datum månad och tid
		

		return '<p>' . '<h4>Dagens Tid och Datum:</h4>' .'<p>' . $time . '</p>';
	}
}