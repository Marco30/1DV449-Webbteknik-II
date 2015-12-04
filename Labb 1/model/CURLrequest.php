<?php
//Marco villegas
namespace model;

class CURL
{

    function CURLGet($iURL)
    {
        $CURLsession = curl_init();// startar CURL session

        curl_setopt($CURLsession, CURLOPT_URL, $iURL);// URL som vi ska hämta

        curl_setopt($CURLsession, CURLOPT_RETURNTRANSFER, 1); //om den är inställd på true, så får man tillbaka dat som en sträng

        $data = curl_exec($CURLsession);//Utför CURL sessionen

        curl_close($CURLsession);// Stäng sessionen

        return $data; // Returnerar den in samlade datan
    }

}
