1DV449, 1DV409
Projekt Rapport
mv22fp
Marco villegas

###Projekt Länkar 

Min Schematisk Bild
https://github.com/Marco30/Mv222fp-1DV449-Webbteknik-II/blob/master/Mitt%20Projekt/MinSchematiskBild.png

Min video finns på följande webbplats
https://youtu.be/W8p0Vj2bt_k

Min applikation finns på följande webbplats
http://vhost9.lnu.se:20081/1dv409/mv222fp

###Projekt Rapport

####Inledning
Jag har gjort en Mashupapplikation, där man kan söka på en stad och få en väder prognos för fem dagar fram över. Jag använde två APIer, den första är Geonames.org, den användes för att få en lista över platser som matchar sökningen man gjort. Den andra är Yr.no, som används för att hitta väder prognos över platsen man sökt på.

####Mashupapplikation
Ramverket jag använder för min Mashupapplikation är ASP.NET MVC 5.  följande språk  använde jag C#, HTML, CSS, SQL och JavaScript. Jag har mina två API anrop på serversidan, när en användare gör en söknings så kontrolleras först sökningen mott min databas. Finns platsen man sökt på i databasen får man en lista med alla platser som matchar sökningen i databasen. 

Om den sökta platsen inte finns på databasen så anropas Geonames.org som ger mig all data på de platser som matchar sökningen jag gjort, den nya informationen som tas i mot lagras i databasen för att användas som datakälla fram över.  Yr.no funkar på samma sätt, förutom att man efter att ha sök i databasen kontrollerar hur aktuellt väder prognosen är. Om den gått ut så hämtar man en ny väder prognos från Yr.no APIen som sedan visas för användaren.  

Om den ena eller båda av APierna är ner så hanteras det med att man bara söker i databasen och visar ett medlande att sökning gjorts i databasen efter som APIen är nere. Min Mashupapplikation hanterar följande händelser, inga sökträffar, sidan finns inte, APIerna går ner och ingen internetanslutning.

####Säkerhet och prestandaoptimering
Jag validerar all indata, pluss att ASP.NET MVC 5 ramverket har skydd mott HTMT taggar, SQL, scripts, CSRF-attacker och  XSS-attacker. Databasen använder Entity Framework som har skydd mot SQL-injections samt att applikationen kommunicerar med databasen med användaren appUser som jag satt begränsade rätigheter till.  

Vad gäller optimering så Cachar jag några aplikations filler med hjälp av Appcache manifest så att de inte behöver laddas ner varje gång man besöker sidan. Jag använder också databasen för Cachning av API data så att man sliper göra flera förfrågningar till APIerna. Sen har jag utgått från praxis att CSS är längst upp i HTML och scripten är längst ner samt varit inne på minifiering av script. 

####Offline-first
När jag tänker på offline-first så tänker jag på automatiks igenkänning, applikationen ska känn av om man är online eller offline.  Jag har gjort ett enkelt JavaScript som kontrollerar om man är online eller offline. Om man blir utan interner så känner den det och man tass till en offline sida automatiks. Får man till baks internet så tas man från offlins sidan till baks till Online sidan.  websidorna och javaScripten jag använder cachar hos användaren för att användas offlien. Vad gäller funktionalitet har min offline applikation just nu ingen funktionalitet mer än att visa att man är offline. Vad gäller om APIerna går ner så har min Mashupapplikation, funktioner som hanterar det med hjälp av databasen och medlar att APIerna är nere.

####Risker med applikationen
Det är att man använder API, min Mashupapplikation är beroende av den data som finns i APIerna om dem skulle gå ner så hanteras det just nu av databasen men skulle APIerna  var när under längre tid så blir väder prognos informationen gammal och oanvändbar. Sen finns självklar risken att databasen går ner och det läder till problemen. 

####Egen reflektion
Det var en lång resa som har haft sina stunder av glädje och sina stunder av frustration.  Men när allt är sagt och gjort så har jag lärt mig mycket.  Jag har tänkt mycket på fel hantering i det här projektet, vad händer om någon av APIerna inte funkar, hur hanterar jag om något inte hittas, hur hanterar jag att man är offline. 

Vad gäller Offline First, så är det något jag inte tänkt så mycket på innan men nu som jag har använt en Offline First lösnings så har det verkligen fåt mig att tänka och reflektera över vad det innebär att var offline och hur man kan hantera det. 

Många av de svårigheter jag stöt på har att göra med att få ASP.NET MVC ramverket att göra som jag vill. Kan samtidigt till lägga att många av mina största triumfer har just varit att få ASP.NET MVC ramverket att ge mig det resultat jag vill ha. Jag implementerade som  praxis att alltid sparar en separat kopia av mitt projekt innan jag gjorde större ändringar för att sedan kunna gå tillbaks om något fel uppstått och gemföra med min tigare kod. Vilket mott slutet var ett väldigt bra beslut efter som jag löste flera buggar med hjälp av det. 
Nu när jag tittar tillbaks på projekt så var det ett bra beslut att köra på ASP.NET MVC, nu förstår jag ramverket mycket bättre än innan.

 










