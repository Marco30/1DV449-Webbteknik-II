<?php
//Marco villegas

class GetMovieInfo
{

    private $cURL;
    private $URLAddress;
    private $MoiveDays;
    private $AvailableMovieDay;
    private $HTMLdata;
    private $MovieURLAddressesToDatta = array();
    private $SelectedDayMovies;


    public function __construct($iURL, CURL $icURL, $AvailableDay)
    {
        $this->URLAddress = $iURL;

        $this->cURL = $icURL;

        $this->HTMLdata = $this->cURL->CURLGet($this->URLAddress); // gör en CURL rekest och hämtar alla data som finns på bio sidan

        $this->MoiveDays = $this->GetAllMovieDays();// hämtar alla bio dagar

        $this->AvailableMovieDay = $this->FindMovieDay($AvailableDay, $this->MoiveDays);// hitta dagen på bio sidan med hjälp av dagen från kalender sidan

        $this->SelectedDayMovies = $this->GetAllMovies();// hämtar alla filmerna som fin dagen all kan

        $this->MakeURLToGetJsonMovieData();


    }

    private function MakeURLToGetJsonMovieData()
    {

        foreach ($this->AvailableMovieDay as $day => $dayValue)// vi skapar addres till filmerna
        {
            foreach ($this->SelectedDayMovies as $movie => $movValue) // loppar igenom alla filerm från dagen man valt
            {
                $this->MovieURLAddressesToDatta[] = $this->URLAddress.'check?day='.$day.'&movie='.$movie;// skapar en adress till varje films sida med tiderna
            }
        }
// test
        /*foreach ($this->urls as $key => $value) {
       echo "<br />Key: $key; Value: $value<br />\n";
   }*/

    }

    private function GetAllMovieDays()// hämtar alla dagar man kan gå på bio
    {
        $AllMovieDays = array();
        $dom = new DomDocument();

        if($dom->loadHTML($this->HTMLdata))
        {
            $xpath = new DOMXPath($dom);

            $MovieValues = $xpath->query("//select[@id='day']/option[not(contains(@disabled, 'disabled'))]/@value");// hämtar hemtar valun som varje dag har i val listan

            $MovieName = $xpath->query("//select[@id='day']/option[not(contains(@disabled, 'disabled'))]");// hämtar alla dagar som finns i id=day

            $M=0;
            foreach ($MovieName as $item)
            {
                $AllMovieDays[$MovieValues->item($M)->value] = $item->nodeValue;// setter values och Sina respektive dagar dem representerar i array
                $M++;
            }
            return $AllMovieDays;
        }
        else
        {
            die("blev fel när skrapa hämtar bio dagar");
        }
    }

    private function GetAllMovies()// hämtar alla filmerna
    {
        $AllMovies = array();
        $dom = new DomDocument();

        if($dom->loadHTML($this->HTMLdata))
        {
            $xpath = new DOMXPath($dom);
            $MovieValues = $xpath->query("//select[@id='movie']/option[not(contains(@disabled, 'disabled'))]/@value");// hämtar alla valus från film listan
            $MovieNames = $xpath->query("//select[@id='movie']/option[not(contains(@disabled, 'disabled'))]");// namn på filmerna

            $M=0;
            foreach ($MovieNames as $item)
            {
                //test
                //echo "<br>".$MovieValues->item($M)->value ."test". $item->nodeValue ."<br>";
                $AllMovies[$MovieValues->item($M)->value] = $item->nodeValue;// till delar array value från sidan och respektive film den till hör
                $M++;
            }



            return $AllMovies;
        }
        else
        {
            die("blev fell när skrapa hemtade filmerna och deras value");
        }
    }

    private function FindMovieDay($iAvailableDay, $iMovieDays)// Gemför alla dagar man kan gå på bio och dagen som funkade för alla vännerna för att få fram rät dag och rätt value
    {
        $MovieAvailableDay = array();

        foreach ($iAvailableDay as $CKey => $calValue)
        {
            foreach ($iMovieDays as $MKey => $movieValue)
            {
                if(preg_match("/".$calValue."/i", $movieValue))// Hittar dagen alla kan och Value till den, så att vi kan använda det för att skapa lenkar
                {
                    $MovieAvailableDay[$MKey] = $movieValue;
                }
            }
        }
        return $MovieAvailableDay;
    }

    public function GetMovieDataFromSelectedDay()// hämtar alla filmer och tider från dagen man valt
    {

        $MovieDataCollection = array();

        foreach ($this->MovieURLAddressesToDatta as $key => $url)// loppar igenom alla URL Adresser = filmerna som går på lördagar
        {

            $MovieDataCollection[] = $this->GetMovieTimeAndAvailability($this->SelectedDayMovies, $this->AvailableMovieDay, $this->cURL->CURLGet($url));

        }

        return $MovieDataCollection;
    }

    private function GetMovieTimeAndAvailability($Movies, $Days, $iHTML)// samlar in alla jason data
    {


        $AllMovieData = array();

        $dom = new DomDocument();
        // test
       //echo "test marco".$html . '<br> <br>';

        if($dom->loadHTML($iHTML))
        {
            $xpath = new DOMXPath($dom);

            $JasonData = $xpath->query("/html");//använder  expression för att hämtar data

            foreach ($JasonData as $item)
            {
                $MultidimensionalDataArray[] = $item->nodeValue;// skapar en multidimensional array med tid, film, tom eller ful
            }



            foreach ($MultidimensionalDataArray as $key => $value)// löper igenom multidimensional array
            {

                foreach (json_decode($value) as $MovieKey => $MovieData)// omvandlas med hjälp av json för att kunna bearbetas _
                {

                    if($MovieData->status == 1)// kontrolärar så att vi bara får in den datan som är från salonger som är lediga
                    {
                        foreach ($Days as $dkey => $MovieDayvalue)// löper igneom array som har dagen man ska gå på bio
                        {

                            /*foreach ($Days as $key => $value)
            {
                echo "test 77<br />Key: $key; Value: $value<br />\n";
            }*/

                            foreach ($Movies as $MovieIDkey => $MovieNameValue)// löper i genom alla filmer som finns
                            {
                                /*foreach ($Movies as $key => $value)
                                {
                                    echo "test 88<br />Key: $key; Value: $value<br />\n";
                                } */

                                    if($MovieData->movie == $MovieIDkey)// använder film value och gemför med value vi fåt från sidan för att se om det är sam film
                                    {
                                        //test
                                        //echo $MovieData->movie;
                                        $AllMovieData[] = array("time" => $MovieData->time, "movieid" => $MovieData->movie, "movieName" => $MovieNameValue, "dayName" => $MovieDayvalue);// multidimensional array skappas med alla det tider som är lediga
                                    }

                            }
                        }
                    }
                }

            }

//test-------------------------------------------------------------

            // testin kod jag använder för att se att alla värden finns med i array
/*
            foreach ($Days as $key => $value)
            {
                echo "test 77<br />Key: $key; Value: $value<br />\n";
            }
            foreach ($Movies as $key => $value)
            {
                echo "test 88<br />Key: $key; Value: $value<br /> $MovieData->movie\n";
            }*/


            /*$keys = array_keys($AllMovieData);

            for($i = 0; $i < count($AllMovieData); $i++)
            {

                echo $keys[$i] . "{<br>";

                foreach($AllMovieData[$keys[$i]] as $key => $value)
                {

                    echo $key . " : " . $value . "<br>";

                }

                echo "}<br>";

            }*/
           // Var_dump($AllMovieData);




//-------------------------------------------------------------


            return $AllMovieData;
        }
        else
        {
            die("fel när man laddat hem lediga film tider, dat som ska precenteras för användaren");
        }

    }


}
