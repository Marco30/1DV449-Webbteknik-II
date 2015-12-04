<?php
//Marco villegas
namespace model;

class GetCalendarsInfo
{

    private $URLAddress;
    private $cURL;
    private $PersonalCalendarInfo = array();// Array objekt som ska hålla alla kaländer info
    private $HTMLdata;
    private $links;

    public function __construct($iURL, CURL $iCURL)
    {
        $this->URLAddress = $iURL;

        $this->cURL = $iCURL;

        $this->HTMLdata = $this->cURL->CURLGet($this->URLAddress); // gör en CURL rekest och hämtar alla data som finns på kalender sidan

        $this->links = $this->GetAllCalendarLinks($this->HTMLdata);// hittar och hämtar all länkar som finn i datan som hämtatas från kalender sidan

        foreach ($this->links as $link)// loppar igenom links arrayen som har alla länkar
        {
            //Slår ihop URL adressen till kalender sidan med varje person kalender länk som vi fåt från funktionen GetAllCalendarLinks
            $this->PersonalCalendarInfo[] = $this->GetCalendarData($this->cURL->CURLGet($this->URLAddress.$link));//slår ihop länkarnar och här hämtar vi varje persons kalender information
        }

    }

    private function GetAllCalendarLinks($iHTML)// hämtar alla tre länkar som finn i kallender sidan
    {
        $AllLinks = array();

        $dom = new \DomDocument();

        if($dom->loadHTML($iHTML))
        {
            $xpath = new \DOMXPath($dom);

            $items = $xpath->query('//ul//a/@href');//använder  expression för att hämtar alla lenkar

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
        $dom = new \DomDocument(); // nyt dom objekt

        if($dom->loadHTML($iHTML))//if satsen körs om man laddat html i objektet
        {
            $xpath = new \DOMXPath($dom);// För att hämta valda html tag så använder jag DomXPath

            $AllDays = $xpath->query('//table//th');//använder  expression för att hämtar alla dagar

            $AllOks = $xpath->query('//table//td');//använder  expression för att hämtar alla ok


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
                $CalendarPersonData[$M2] = array("day" => $ALLDaysData[$M2], "Available" => $Available->nodeValue); // skapar en multi-dimensional array med day = dagar och Available = med när person är ledig
                $M2++;
            }


            return $CalendarPersonData;
        }
        else
        {
            die("blev fel när man hämtade kalender datin info om dag och om ledig");
        }
    }

    public function DayEveryoneAvailable()
    {

        $EveryonesAvailabelDay = array();
        $Days = array("Monday" => 0, "Tuesday" => 0, "Wednesday" => 0, "Thursday" => 0, "Friday" => 0, "Saturday" => 0, "Sunday" => 0);


        foreach ($this->PersonalCalendarInfo as $days => $daysValue)
        {
            foreach ($this->PersonalCalendarInfo[$days] as $key => $OkValue)// lopar i genom och plusa en ett på den dagen som matchar if satsen och den som får mest är den dag som alla är ledig på
            {
                if(preg_match("/ok/i", $OkValue["Available"]))
                {
                    $Days[$OkValue["day"]] += 1;

                }
            }
        }


        $OkValue = max($Days);
        $key1 = array_search($OkValue, $Days);// får fram dagen då flest kunde
        $EveryonesAvailabelDay[$key1] = $key1;//till delar dagen till arrayen

        // avänd för att testa echo 'test<br>' . $EveryonesAvailabelDay[$key1] . '<br>';

       /* foreach ($EveryonesAvailabelDay as $key => $value) {
            echo "test 88"."<br />Key: $key; Value: $value<br />\n";
        }*/

        // översättning
        $EveryonesAvailabelDayInSV = array();
        $TranslatDaysSV = array("monday" => "måndag", "tuesday" => "tisdag", "wednesday" => "onsdag", "thursday" => "torsdag","friday" => "fredag", "saturday" => "lördag","sunday" => "söndag");

        foreach ($EveryonesAvailabelDay as $enKey => $value)
        {

            foreach ($TranslatDaysSV as $mixKey => $enValue)//lopar igenom och hittar engelska dagarna och ändrar dem till svenska
            {
                if(preg_match("/".$enKey."/i", $mixKey))
                {
                    $EveryonesAvailabelDayInSV[] = $TranslatDaysSV[$mixKey];
                }
            }
        }

        // testa
        /*foreach ($EveryonesAvailabelDayInSV as $key => $value) {
            echo "<br />Key: $key; Value: $value<br />\n";
        }*/

        return $EveryonesAvailabelDayInSV;

    }

}
