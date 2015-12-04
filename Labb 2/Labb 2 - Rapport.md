1DV449 - Webbteknik II
Labb 2 - Min Rapport -
Marco villegas - mv22fp

###Säkerhetsproblem

####SQL injections 
[1]SQL Injection är en teknik där en elak användare skapar eller förändrar befintliga SQL-kommandon för att exponera dolda data eller för att utföra farlig systemnivå kommandon på webbsidan databas. [2]Detta görs genom att inmatad värden och kombinera med statiska parametrar för att bygga en SQL-fråga. 

inloggningsformulären har ingen validering, det man matar in i e-postadress och lösenord text rutan kontrolleras inte och man kontrollerar inte heller att e-postadress finns i databasen. Det finns valideringen på att e-postadress text rutan ska var en e-postadress men inte mer än så, kunde logga in som Admin.

e-postadress: marco.villegas@live.se
lösenord:  ' or 0=0 -- 

Man kan också skriva SQL injections i meddelade text rutan när man är inloggad, vilket om man är en elak användare kan betyda att man tömmer hela användardatabasen eller kommer åt annat känsligt information.

Man kan själv implementera en funktion som körs när meddelande formuläret och inloggningsformuläret skickas och kontrollerar om det inmatade tecken består av rätt format och tecken längd. [3] Men bästa sättet för att hindra användare från att göra SQL injections är att använda API som redan har färdiga skydd som automatiskt hittar SQL kod.

 
####Broken authentication and session management

[4]Applikationsfunktioner som rör autentisering och sessionshantering är fel implementerade, vilket gör att en elak användare kan koma åt lösenord, nycklar, eller session token för att kunna ta över en användares identitet.

När man varit in loggad och sen loggar ut, så fröstörs inte användarens session-data.  Skriver man in http://localhost:3000/message så är man inloggad som den som senast var in loggad. Vilket betyder att om admin inte logar ut och lämnar dator så kan en elak användare koma åt användarens konto så länge den använder samma dator. 

[5] hålla all din session och autentisering relaterad information skyddad. Bästa setter är att Uppfylla alla autentiserings och session kraven som anges i OWASP Application Security Verification Standard (ASVS) områden V2 (autentisering) och V3 (Session Management). Exmpel på sessions funktion kan vara att den tar bort session när man logar ut och sätter en sluts tid på sessionen så om användaren glömmer logga ut så ta sessionen tas bort automatiskt efter en vis tid.

####Databas
[6]Många webbapplikationer skyddar inte känsliga data som kreditkortsnummer och autentiseringsuppgifter. Elaka användare kan stjäla eller ändra sådana svagt skyddade uppgifter för att genomföra brott. Känsliga uppgifter skyddas extra mycket, som till exempel med kryptering till och från databasen.
Som saker är just nu så kommer man åt databasen genom att ange dess sökväg.  http://localhost:3000/static/message.db. DB-filen är okrypterad så man kan öppna den med word och se alla information utan någon större svårighet. Detta öppnar upp för att elaka användare at kommer åt känslig information som de inte har rätt till. Man kan också koma åt alla meddelanden genom att skriva http://localhost:3000/message/data och få ett Jason format från databasen
 [7] man måste planera för attacker som kan komma inifrån och från externa användare. kryptera alla känsliga data som ska till och från databasen, förvara inte känsliga uppgifter i onödan man gör bäst i att göra sig av med känslig data man inte använder så fort det används klart. 


####XSS 

[8]Webbapplikationer tar i mot opålitliga data och skickar det till webbläsaren utan ordentlig validering. Det kan låta en elak användare köra skript i offrets webbläsare som kan kapa användarsessioner, vanställa webbplatser, eller omdirigera användaren till skadliga webbplatser.

Det finns ingen Validering på meddelades text rutan när man är inloggad, man kan skriva in javascript /HTML taggar men också SQL-kod. Har testade <a href='#' onclick='alert("Hej mitt namn är marco")'>Hej</a>

[9]Se till att endast tillåta en viss längd av tecken och att tecken som ingår i skript syntaxer tas bort, detta kommer att göra det omöjligt för webbapplikationen att se det som kod



###Optimering
####HTTP-caching 

[10]HTTP-caching är när webbläsaren lagrar lokala kopior av webbresurser för snabbare hämtning nästa gång den behöver resursen. När en webbsida är helt cachad kan webbläsaren väljer att inte kontakta servern alls och bara använda sin egen cachad kopia. 

[11]Expires är sätt att kontroll så att inte resurserna blir för gamla. Man setter ett datum från vilket den cachade resursen inte längre betraktas som giltigt. Från detta datum så kommer webbläsaren att begära en ny kopia av resursen. Fram till dess så använder webbläsare den lokal cachad kopia den har. 

Som det är nu så är cachning avstängd, webbsidan måste ladda hem alla filer varje gång man besöker sidan. Det gör så att man gör onödigt många HTTP-begäran och tar när prestandan. för att öka prestandan så bör man startat caching och ange när innehåll går u /hur länge innehållet är färskt.

####Strukturerar upp Kod
 [12]Javasscript borde sättas längs ner vid slut body HTML tagen som det är just nu så är Skripten placeras i sidans sidhuvud. Om script är stort så kan det ta tid att laddas in och orsakar onödig laddningstid. Det kommer i sin tur att uppfattas av användaren som om sidan är seg. [13]Jobbar man med ett projekt som innehåller mycket javascript-kod, kan det vara resurseffektivt att komprimera och minifiera sina javascript. 

Filernas storlek kan minskas avsevärt vilket förstås leder till en bättre och snabbare respons från webbserverns sida. Css ska däremot vara i sidhuvudet så att det ladas in så fort som möjligt samt att man ska undvika att ha in line CSS i HTML kod som det är nu. [14]minska onödig HTTP requests genom att undvika att försöker hämta en fil som inte finns eller inte kommer användas för det segar ner webbsidan, bootstrap.css ladas in men används inte av webbsidan. 

####Reflektioner
Tycker att den här labben varit en väldig lärorik erfarenhet att läs om det svagheter som fins är en sak. Mena att testa och utforska de svagheter som finns är en helt annan. 
Den här labben har fåt mig att tänka på så många saker vad gäller min programmering. Saker som jag inte tänkt på tidigare, nu fröstår man bättre varför man ska tänka på säkerhet. Det krävs inte mycket för någon att förstöra något som kan ha tagit en flera månader eller till och med år att bygga.  
Jag tror att man bara genom att förstå svagheterna som finns i systemen kan läras sig att skydda sig från dem.  Vad gäller optimering så var det nysa saker blandat med gamla, som jag känner igen från tidigare kurser. Optimeringen har fåt mig att tänka på vad jag har i min applikation och hur jag väljer at förvara och ladda in min kod. Samt tänka på caching vilket är något jag inte tänkt på innan.  Alltid bra att repeteras saker och se saker från andra perspektiv samt läras sig nya saker.    

##Referenser
[1] Top 10 2013-A1-Injection - https://www.owasp.org/index.php/Top_10_2013-A1-Injection
[2] SQL injections - http://php.net/manual/en/security.database.sql-injection.php
[3] SQL Injection Prevention Cheat Sheet -https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet
[5] Top 10 2013-Top 10 - https://www.owasp.org/index.php/Top_10_2013-Top_10
[4] Top 10 2013-A2-Broken Authentication and Session Management -https://www.owasp.org/index.php/Top_10_2013-A2-Broken_Authentication_and_Session_Management
[6] Top 10 2013-Top 10 - https://www.owasp.org/index.php/Top_10_2013-Top_10
[7] Top 10 2013-A6-Sensitive Data Exposure - https://www.owasp.org/index.php/Top_10_2013-A6-Sensitive_Data_Exposure
[8] Top 10 2013-A3-Cross-Site Scripting (XSS) - https://www.owasp.org/index.php/Top_10_2013-A3-Cross-Site_Scripting_%28XSS%29
[9] OWASP Periodic Table of Vulnerabilities - Cross-Site Scripting (XSS) -https://www.owasp.org/index.php/OWASP_Periodic_Table_of_Vulnerabilities_-_Cross-Site_Scripting_(XSS)
[10] Caching Tutorial for Web Authors and Webmasters - https://www.mnot.net/cache_docs/
[11] Increasing Application Performance with HTTP Cache Headers - https://devcenter.heroku.com/articles/increasing-application-performance-with-http-cache-headers
[12]Souders, Steve. Chapter 6. High Performance Web Sites. Farnham: O'Reilly, 2007. Print.
[13]Souders, Steve. Chapter 10. High Performance Web Sites. Farnham: O'Reilly, 2007. Print.
[14] Steve Souders, High Performance Web Sites: Rule 1: Make Fewer HTTP Requests, O'Reilly, 2007

