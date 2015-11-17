<?php

$data = curl_get_request("http://localhost:8080/cinema/check?day=02&movie=01");
//var_dump($data);


$result = array();

$dom = new DomDocument();

if($dom->loadHTML($data))
{
    $xpath = new DOMXPath($dom);

    $items = $xpath->query("/html");

    foreach ($items as $item)
    {
        $r[] = $item->nodeValue;
    }

    foreach ($r as $key => $value) {
        echo "test <br />Key: $key; Value: $value<br />\n";
    }

    $result = array();

    foreach ($r as $key => $value) {

        foreach (json_decode($value) as $mkey => $mvalue)
        {
            # code...
            //var_dump($mvalue);
            if($mvalue->status == 1)
            {
                foreach ($days as $dkey => $dvalue)
                {

                    foreach ($movies as $ykey => $yvalue)
                    {

                        if($mvalue->movie == $ykey)
                        {
                            $result[] = array(
                                "time" => $mvalue->time,
                                "movieid" => $mvalue->movie,
                                "movieName" => $yvalue,
                                "dayName" => $dvalue
                            );
                        }

                    }
                }
            }
        }

    }

    foreach ($result as $key => $value) {
        echo "<br />Key: $key; Value: $value<br />\n";
    }

}


/*
$result = array();
$dom = new DomDocument();

if($dom->loadHTML($data)){
    $xpath = new DOMXPath($dom);
    $itemsValues = $xpath->query("//select[@id='movie']/option[not(contains(@disabled, 'disabled'))]/@value");// hämtar alla valus från film listan
    $items = $xpath->query("//select[@id='movie']/option[not(contains(@disabled, 'disabled'))]");// namn på filmerna

    $i=0;
    foreach ($items as $item) {
        $result[$itemsValues->item($i)->value] = $item->nodeValue;// till delar array value och respektive film den till hör
        $i++;
    }

    foreach ($result as $key => $value) {
        echo "<br />Key: $key; Value: $value<br />\n";
    }



}else
{
    die("blev fell när skrapa hemtade filmerna och deras value");
}*/

/*
$dom = new DOMDocument();
$result = array();


if($dom->loadHTML($data))
{
    $xpath = new DOMXPath($dom);
    $itemValues = $xpath->query("//select[@id='day']/option[not(contains(@disabled, 'disabled'))]/@value");
    $items = $xpath->query("//select[@id='day']/option[not(contains(@disabled, 'disabled'))]");

    $i=0;
    foreach ($items as $item)
    {
        //$text = $itemValues->item($i)->value = $item->nodeValue;
        //echo 'Marco33 <br><br>'. $text .'<br><br>' ;
        //echo 'Marco <br>'. $item->nodeValue .'<br>' ;
       // echo 'Marcotest3 <br>'. $itemValues->item($i)->value . $item->nodeValue .'<br>';

        //$result[$item->nodeValue] = $item->nodeValue;
        $result[$itemValues->item($i)->value] = $item->nodeValue;
        $i++;

    }

    foreach ($itemValues  as $item1)
    {
        echo 'Marco2 <br>'. $item1->nodeValue .'<br>' ;

    }
    //var_dump($items);
    //var_dump( $itemValues);
    //echo '<br>'. $items .'<br>';

    /*var_dump(array_keys($result));
    echo '<br>';
    var_dump(array_values($result)) ;
    echo '<br>';
    echo '<br>';
    echo 'Hej1<br>';
    var_dump($item->nodeValue) ;
    echo '<br>';
    echo 'hej2<br>';

    $M = 0;
    var_dump($itemValues->item($M)->value);*/

   /*foreach ($items as $value) {
        echo '<br>';
        echo '<br>';
        echo $value->nodeValue;
    }



    foreach ($result as $key => $value) {
        echo "<br />Key: $key; Value: $value<br />\n";
    }

}
else
{
    diw("fel vid in slsning av HTML");
}

*/
    function curl_get_request($url)
    {
        $ch = curl_init();// startar CURL session
        curl_setopt($ch, CURLOPT_URL, $url);// URL som vi ska hämta
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //om den är inställd på true, så får man tillbaka dat som en sträng

        $data = curl_exec($ch);//Utför CURL sessionen
        curl_close($ch);// Stäng sessionen

        return $data;
    }

    function curl_post_request($url){
        $ch = curl_init();// startar CURL session
        curl_setopt($ch, CURLOPT_URL, $url);// URL som vi ska hämta
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//om den är inställd på true, så får man tillbaka dat som en sträng
        curl_setopt($ch, CURLOPT_POST, true);//begära en HTTP POST

        $data = curl_exec($ch);//Utför CURL sessionen
        curl_close($ch);// Stäng sessionen

        return $data;
    }
