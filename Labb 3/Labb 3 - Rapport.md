1DV449 - Webbteknik II
Labb 3 - Min Rapport -
Marco villegas - mv22fp

#Reflektion labb 3

####Vad finns det för krav du måste anpassa dig efter i de olika API:erna?

För att koma åt Googel maps API så behövde jag använda mig av en API nyckel, som jag kunde få från Googel API konsol sida i mitt Google konto.
Vad gäller Sveriges Radios API så var det öppet att använda utan några större begränsningar förutom ett förslag "var snäll mot APIet och gör så få anrop som möjligt". 


####Hur och hur länga cachar du dittdata för att slippa anropa API:erna i onödan?

Min cachningstid är inställd på 2 minuter, just nu. Cachningen fungerar som så att jag vid varje hämtning av Json datan från Sveriges Radios API sparar en json fil med all data och inkluderar en tidsstämpel med tiden då den hämtats. När ett anrop sedan görs från en klient kontrollerar servern först vilket värde tidsstämpeln har i den cachade filen. Om detta tidsstämpeln från Json filen överskrider den satta cachningstiden, så tas den sparade datan och presenteras för användaren, i annat fall görs en ny hämtning från Sveriges Radios API.

####Vad finns det för risker med din applikation?

Den första är att APIerna slutar fungera och då måste man kunna hantera det genom att till exempel ha en funktion som kan hantera en son situation genom att visar ett fel meddelande och laddar in den senaste sparade Jason filen som hämtats från APIerna.

Som det är nu så måste man lada om sidan för att trafikinformation ska uppdateras. Det kan finnas dem som använder min webb plats och tror att nya trafikhändelser läggs till automatisk och där med går ut på vägarna med information som inte är aktuellt. Vilket kan ledda till irritation hos användaren.   

####Hur har du tänkt kring säkerheten i din applikation?

Jag har begränsat min Googel API nykel så att jag man bara kan använda den från min webbplats http://paradiseblue.nu. Så att ingen annan kan använda min API nyckel från en anan plats. 

Jag filtrerar API datan som ska visas på sidan, kontrollerar att det inte finns html taggar i datan från APIen. Om en elak användare skulle komma åta API och skicka ut Kod istället för text strängar så filtrerar jag den. En sådan attack skulle kunna skapa länkar som dirigera om användaren till en skadlig webb plats.


####Hur har du tänkt kring optimeringen i din applikation?

Har gjort allt Jason data hantering på servern så att inte det görs hos användaren Delar av koden som endast behöver köras en gång körs bara en gång. Generering av karta och populering av alla marker arrayer sker endast en gång. Funderar på att komprimera och minifiera mina javascript för att göra dem resurseffektiva.

