<?php
//Marco villegas
require_once('model/CURLrequest.php');
require_once('model/GetStartPageInfo.php');
require_once('model/GetCalendarsInfo.php');
require_once('model/GetMovieInfo.php');


class CrawlerController
{

    private $Crawler_View;

    //public function __construct(CrawlerView $iCrawler_View)// tar int adressen man skrivit in formulären och till delar den till variable
    public function __construct()// tar int adressen man skrivit in formulären och till delar den till variable
    {
        //$this->Crawler_View = $iCrawler_View;

        $this->Crawler_View =$CrawlerView = new CrawlerView();
    }

    public function MyCrawlerController()
    {
        if ($this->Crawler_View->CheckPost())// if satsen körs om amn tryckt på post i formulären
        {

            $CURL = new CURL();

            $iURL = $this->Crawler_View->GetUrl();// hämtar adresn man mattat in

            //test
            //var_dump(iURL);


            $StartPage_C = new GetStartPageInfo($iURL, $CURL);// construct

            $StartPage_C->GetLinksFromStartPage();// hämtar länkarna som finns i sidan


            $Calendar_C = new GetCalendarsInfo($iURL.$StartPage_C->GetLinkToCalanderPage(), $CURL); // construct tar in URL adres till sidan med alla kalender

            $DayEveryoneAvailable = $Calendar_C->DayEveryoneAvailable();// Kontrollerar vilken daga alla kan

            // test
            /*foreach ($DayEveryoneAvailable as $key => $value)
         {
             echo "test 77<br />Key: $key; Value: $value<br />\n";
         }*/

            $Movie_C = new GetMovieInfo($iURL.$StartPage_C->GetLinkToMoviePage(), $CURL, $DayEveryoneAvailable);// construct

            $MovieDataFromSelectedDay = $Movie_C->GetMovieDataFromSelectedDay();// Tar fram all information om filmerna man vill ses

            //test
            //var_dump(MovieDataFromSelectedDay );

            return $this->Crawler_View->GetHTML_TabelOutput($MovieDataFromSelectedDay);//Visar dagen all kan och all filmer som det finns plats till och tiderna dem går på

        }
        else
        {
            return $this->Crawler_View->GetHTML_InputForm();// visar formulären
        }
    }

}
