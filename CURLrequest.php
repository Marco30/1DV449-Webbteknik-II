<?php

class CURL
{

    function CURLGet($iURL)
    {
        $CURLsession = curl_init();// startar CURL session

        curl_setopt($CURLsession, CURLOPT_URL, $iURL);// URL som vi ska h�mta

        curl_setopt($CURLsession, CURLOPT_RETURNTRANSFER, 1); //om den �r inst�lld p� true, s� f�r man tillbaka dat som en str�ng

        $data = curl_exec($CURLsession);//Utf�r CURL sessionen

        curl_close($CURLsession);// St�ng sessionen

        return $data; // Returnerar den in samlade datan
    }

}
