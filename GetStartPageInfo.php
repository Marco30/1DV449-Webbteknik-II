<?php


class GetStartPageInfo
{

    private $URLAddress;
    private $HTMLdata;
    private $AllStartPageLinks;

    public function __construct ($iURL, CURL $iCURL)
    {
        $this->curler = $iCURL;

        $this->URLAddress = $iURL;//Adressen

        $this->HTMLdata = $this->curler->CURLGet($this->URLAddress); // hämtar URL adresen datat

    }

    public function GetLinkToMoviePage()
    {
        foreach ($this->AllStartPageLinks as $key => $value)
        {
            if(preg_match("/cinema/i", $this->AllStartPageLinks[$key]))
            {
                $result =  preg_replace ("~/~", "",$this->AllStartPageLinks[$key]);
                return $result.='/';
            }
        }
        return null;
    }


    public function GetLinkToCalanderPage()
    {
        foreach ($this->AllStartPageLinks as $key => $value)// loppar igenom arrayen
        {
            if(preg_match("/calendar/i", $this->AllStartPageLinks[$key]))// Gör ett reguljärt uttryck match
            {
                $result =  preg_replace ("~/~", "",$this->AllStartPageLinks[$key]);// Genomföra regular expression sökning och ersäter
                return $result.='/';
            }
        }
        return null;
    }

    public function GetLinksFromStartPage()
    {
        $AllLinks = array();

        $dom = new DomDocument();// nyt dom objekt

        if($dom->loadHTML($this->HTMLdata))//if satsen körs om man laddat html i objektet
        {
            $xpath = new DOMXPath($dom);// För att hämta valda html tag så använder jag DomXPath

            $StartPageLinks = $xpath->query('//ol//a/@href');//använder  expression för att hämtar alla lenkar

            foreach ($StartPageLinks as $Link)// lopar igenom varible för att få alla values i en array
            {
                $AllLinks[] = $Link->nodeValue;
            }
            $this->AllStartPageLinks = $AllLinks;// array till dellas
        }
        else
        {
            die("Blev fel när man laddar hem länkarna på sidan");
        }
    }



}
