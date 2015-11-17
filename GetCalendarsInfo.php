<?php



class GetCalendarsInfo
{

    private $URLAddress;
    private $cURL;
    private $PersonalCalendarInfo = array();// Array objekt som ska h�lla alla kal�nder info
    private $HTMLdata;

    public function __construct($iURL, CURL $iCURL)
    {
        $this->URLAddress = $iURL;

        $this->cURL = $iCURL;

        $this->HTMLdata = $this->cURL->CURLGet($this->URLAddress); // g�r en CURL rekest och h�mtar alla data som finns p� kalender sidan

        $links = $this->GetAllCalendarLinks($this->HTMLdata);// hittar och h�mtar all l�nkar som finn i datan som h�mtatas fr�n kalender sidan

        foreach ($links as $link)// loppar igenom links arrayen som har alla l�nkar
        {
            //Sl�r ihop URL adressen till kalender sidan med varje person kalender l�nk som vi f�t fr�n funktionen GetAllCalendarLinks
            $this->PersonalCalendarInfo[] = $this->GetCalendarData($this->cURL->CURLGet($this->URLAddress.$link));//sl�r ihop l�nkarnar och h�r h�mtar vi varje persons kalender information
        }

    }

    private function GetAllCalendarLinks($iHTML)// h�mtar alla tre l�nkar som finn i kallender sidan
    {
        $AllLinks = array();

        $dom = new DomDocument();

        if($dom->loadHTML($iHTML))
        {
            $xpath = new DOMXPath($dom);

            $items = $xpath->query('//ul//a/@href');//anv�nder  expression f�r att h�mtar alla lenkar

            foreach ($items as $item)
            {
                $AllLinks[] = $item->nodeValue;
            }
            return $AllLinks;
        }
        else
        {
            die("fel");
        }
    }



    private function GetCalendarData($iHTML)
    {

        $CalendarPersonData = array();
        $dom = new DomDocument(); // nyt dom objekt

        if($dom->loadHTML($iHTML))//if satsen k�rs om man laddat html i objektet
        {
            $xpath = new DOMXPath($dom);// F�r att h�mta valda html tag s� anv�nder jag DomXPath

            $AllDays = $xpath->query('//table//th');//anv�nder  expression f�r att h�mtar alla dagar

            $AllOks = $xpath->query('//table//td');//anv�nder  expression f�r att h�mtar alla ok


            $ALLDaysData = array();

            $M1 = 0;
            foreach ($AllDays as $day)
            {
                $ALLDaysData[$M1] = $day->nodeValue;
                $M1++;
            }

            $M2 = 0;
            foreach ($AllOks as $Available)
            {
                $CalendarPersonData[$M2] = array("day" => $ALLDaysData[$M2], "Available" => $Available->nodeValue); // skapar en multi-dimensional array med day = dagar och Available = med n�r person �r ledig
                $M2++;
            }


            return $CalendarPersonData;
        }
        else
        {
            die("blev fel n�r man h�mtade kalender datin info om dag och om ledig");
        }
    }

    public function DayEveryoneAvailable()
    {
        $Days = array("Friday" => 0, "Saturday" => 0, "Sunday" => 0);

        foreach ($this->PersonalCalendarInfo as $days => $daysValue)
        {
            foreach ($this->PersonalCalendarInfo[$days] as $key => $OkValue)// lopar i genom och plusa en ett p� den dagen som matchar if satsen och den som f�r mest �r den dag som alla �r ledig p�
            {
                if(preg_match("/ok/i", $OkValue["Available"]))
                {
                    $Days[$OkValue["day"]] += 1;

                }
            }
        }

        $EveryonesAvailabelDay = array();

        $OkValue = max($Days);
        $key1 = array_search($OkValue, $Days);// f�r fram dagen d� flest kunde
        $EveryonesAvailabelDay[$key1] = $key1;//till delar dagen till arrayen

        // av�nd f�r att testa echo 'test<br>' . $EveryonesAvailabelDay[$key1] . '<br>';

        /*foreach ($EveryonesAvailabelDay as $key => $value) {
            echo "<br />Key: $key; Value: $value<br />\n";
        }*/

        return $EveryonesAvailabelDay;
    }

}
