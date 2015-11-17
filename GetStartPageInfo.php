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

        $this->HTMLdata = $this->curler->CURLGet($this->URLAddress); // h�mtar URL adresen datat

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
            if(preg_match("/calendar/i", $this->AllStartPageLinks[$key]))// G�r ett regulj�rt uttryck match
            {
                $result =  preg_replace ("~/~", "",$this->AllStartPageLinks[$key]);// Genomf�ra regular expression s�kning och ers�ter
                return $result.='/';
            }
        }
        return null;
    }

    public function GetLinksFromStartPage()
    {
        $AllLinks = array();

        $dom = new DomDocument();// nyt dom objekt

        if($dom->loadHTML($this->HTMLdata))//if satsen k�rs om man laddat html i objektet
        {
            $xpath = new DOMXPath($dom);// F�r att h�mta valda html tag s� anv�nder jag DomXPath

            $StartPageLinks = $xpath->query('//ol//a/@href');//anv�nder  expression f�r att h�mtar alla lenkar

            foreach ($StartPageLinks as $Link)// lopar igenom varible f�r att f� alla values i en array
            {
                $AllLinks[] = $Link->nodeValue;
            }
            $this->AllStartPageLinks = $AllLinks;// array till dellas
        }
        else
        {
            die("Blev fel n�r man laddar hem l�nkarna p� sidan");
        }
    }



}
