<?php

$data = curl_get_request("http://localhost:8080/calendar/paul.html");
//var_dump($data);

$dom = new DOMDocument();
$result = array();

if($dom->loadHTML($data))
{
$xpath= new DOMXPath($dom);
    //$items = $xpath->query('//UL[@id = "blogs-list"]');
    $days = $xpath->query('//table//th');
    $ok = $xpath->query('//table//td');



    $NodeDayValue = array();
    $i = 1;
    foreach ($days as $day)
    {
        $NodeDayValue[$i] = $day->nodeValue;
        $i++;
    }

    $j = 1;
    foreach ($ok as $isOk)
    {
        $result[$j] = array("day" => $NodeDayValue[$j], "isOk" => $isOk->nodeValue);
        $j++;
    }


    $last = count($result) - 1;

    foreach ($result as $i => $row)
    {
        $isFirst = ($i == 0);

        $isLast = ($i == $last);

        echo $row['day'] .'<br>'. $row['isOk'] .'<br>';
}



}
else
{
    diw("fel vid in slsning av HTML");
}

    function curl_get_request($url)
    {
        $ch = curl_init();// startar CURL session
        curl_setopt($ch, CURLOPT_URL, $url);// URL som vi ska h�mta
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //om den �r inst�lld p� true, s� f�r man tillbaka dat som en str�ng

        $data = curl_exec($ch);//Utf�r CURL sessionen
        curl_close($ch);// St�ng sessionen

        return $data;
    }

    function curl_post_request($url){
        $ch = curl_init();// startar CURL session
        curl_setopt($ch, CURLOPT_URL, $url);// URL som vi ska h�mta
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//om den �r inst�lld p� true, s� f�r man tillbaka dat som en str�ng
        curl_setopt($ch, CURLOPT_POST, true);//beg�ra en HTTP POST

        $data = curl_exec($ch);//Utf�r CURL sessionen
        curl_close($ch);// St�ng sessionen

        return $data;
    }
