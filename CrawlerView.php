<?php


class CrawlerView
{

    private static $URLAddress = "URLInputView::url";// sidans adress : http://localhost:8080/
    private static $Post = "URLInputView::Post";// post varaibel


    public function GetUrl()//Funktion som tar ut URL adressen man skrivit i Text rutan
    {
        return $_POST[self::$URLAddress];
    }

    public function CheckPost()//Funktion som kontrollerar att man postat
    {
        return isset($_POST[self::$Post]);
    }


    public function GetHTML_InputForm()//HTML formulären
    {
        return '
            <h2>Sök filmer, tider och dagar som passar</h2>
			<form  method="post" >
			<fieldset>
			<legend>Web Skrapa - mata in URL dress</legend>
				<input type="text" id="' . self::$URLAddress . '" name="' . self::$URLAddress . '" value= "http://localhost:8080/" />
				<input type="submit" name="' . self::$Post . '" value="Börja Skrapa"/>
			</fieldset>
			</form>
		';
    }

    public function GetHTML_TabelOutput($AllMovieData)// Funktion som löper igenom multidimensional array och presenterar information i HTML tabel
    {


        $html = ' <h2>filmer, tider och dagar som passar alla</h2> <table border="1" style="width:30%">';

        $html .='<tr>
    <td><b>Film</b></td>
    <td><b>Tid</b></td>
    <td><b>Dag</b></td>
  </tr>';

        for($M = 0; $M < count($AllMovieData); $M++)
        {


            foreach($AllMovieData[$M] as $key => $value)// löper igenom och hitar infot jag vill presentera
            {

                // var_dump($value); test

                $html.='<tr>';

                $html.= '<td>' .$AllMovieData[$M][$key] ["movieName"] . '</td>';
                $html.= '<td>' .$AllMovieData[$M][$key] ["time"] . '</td>';
                $html.= '<td>' .$AllMovieData[$M][$key] ["dayName"] . '</td>';


                $html.='</tr>';

            }

        }

        $html.='</table>';


        return $html;
    }

}
