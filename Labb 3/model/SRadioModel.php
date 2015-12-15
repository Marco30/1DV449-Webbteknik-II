<?php


class SRadioModel
{

	private $maxAmountOfResults;
	private $url;
	private $filename;
	private $cacheTimeInMinutes;
	private $tryCache = true;

	public function __construct()
	{
		$this->maxAmountOfResults = 100;// Max antal information från apien
		$this->url = "http://api.sr.se/api/v2/traffic/messages?format=json&pagination=false";// apien vi hämtar från
		$this->filename = "jsonFile.txt";// fil att spara infomraiton i
		$this->cacheTimeInMinutes = 2;// hur länge vi chachar inan vi kontaktar sidan igen
	}

	private function curl_get($url)
	{

		$CURLsession = curl_init();// startar CURL session

		$userAgent = "";

		// Set URL och andra lämpliga alternativ man vill ha
		$options = array
		(
				CURLOPT_HTTPHEADER => array('Accept' => 'application/json; charset=utf-8'),
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_AUTOREFERER => TRUE,
				CURLOPT_USERAGENT => $userAgent,
				CURLOPT_URL => $url,
		);

		curl_setopt_array($CURLsession, $options);

		$data = curl_exec($CURLsession);//Utför CURL sessionen

		curl_close($CURLsession);// Stäng sessionen

		return $data;// Returnerar den in samlade datan
	}


	public function getCacheTimeInMinutesg()// omvanldar cache tiden till string text
	{
		$ret = '-' . $this->cacheTimeInMinutes;// tiden läggs till i string

		if($this->cacheTimeInMinutes > 1)// om det är störe än 1 minut så är det minuter som läggs till i text trängen
		{
			$ret .= ' minutes';
		}
		else
		{
			$ret .= ' minute';
		}

		return $ret;

	}

	public function NewCallOrUseCache()// funkntione som kontrolerar om man ska använda cachead data eller hämta nyt
	{

		$jsonFile = file_get_contents($this->filename);// läser in alla dat som finns i jeson filen

		if($this->tryCache)
		{
			if(!empty($jsonFile))
			{

				$decodedJson = json_decode($jsonFile);//jseon filen gör om för att kuna hanteras bättre

				$timestamp = $decodedJson->timestamp;// man tar ut tiden för den cachade datan

				$cacheTime = date('Y/m/d H:i:s', strtotime($this->getCacheTimeInMinutesg()));// skapar timestamp

				if($cacheTime > $timestamp)// om cacheTime är störe än timestamp från jason filen så ladar vi när data
				{
					return $this->GetJsonData();
				}
				else// om chachestamp fortfarande är aktuel så kör vi från jason filen
				{
					return json_encode($decodedJson, JSON_PRETTY_PRINT);
				}
			}
		}
		else
		{
			return $this->GetJsonData();
		}
	}

	private function GetJsonData()// hämtar hem Jason Datan som vi ska använda
	{

		$ret = $this->curl_get($this->url);//Använder CURL för att hämta datan

		$ret = json_decode($ret, true);//JSON kodad sträng och omvandlar den till en variabel i PHP

		$messages = $ret['messages'];

		$reversed = array_reverse($messages);
		$trimmedMessages = array();

		if(count($reversed) < $this->maxAmountOfResults)// här fixar vi så att det bara de hundra senaste trafik händelserna sparas
		{
			$this->maxAmountOfResults = count($reversed);
		}

		for ($i=0; $i < $this->maxAmountOfResults; $i++)// formaterar json datan title och decription
		{
			strip_tags($reversed[$i]['title']);
			strip_tags($reversed[$i]['description']);

			$trimmedMessages[$i] = $reversed[$i];
		}

// skapar en ny array med alla ändringar och skpar en timestamp som ska användas för att kontrolerar cachtiden
		$jsonData = array(
    		'timestamp' => date('Y/m/d H:i:s', strtotime('now')),
    		'retrievedData' => $trimmedMessages
    	);

    	$jsonData = json_encode($jsonData, JSON_PRETTY_PRINT);

   		file_put_contents($this->filename, $jsonData);// sparar den trimade arrayen till text fill

		return $jsonData;
	}



}