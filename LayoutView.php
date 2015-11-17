<?php
//Marco villegas
//require_once('view/DateTimeView.php');
require_once('DateTimeView.php');

class LayoutView
{

    public function showHTML($content)// Funktion som visar HTML 	//' . $dtv->show() . '  $dtv = new DateTimeView();
    {

        if($content === NULL)
        {
            throw new Exception("showHTML does not allow body to be null");
        }
		else
		{
			$dtv = new DateTimeView();

			echo '
		<!DOCTYPE html>
		<html>
			<head>
			<title>Login</title>
			<meta charset ="utf-8" />
			</head>
			<body>
			<h1>Marco - Labb1</h1>
			' . $content . '
			' . $dtv->show() . '
			</body>
		</html>';

		}
    }

}