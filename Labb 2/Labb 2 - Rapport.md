###1DV449 - Webbteknik II
###Labb 2 - Min Raport 
###Marco villegas - mv22fp

###S�kerhetsproblem

####SQL injections 
[1]SQL Injection �r en teknik d�r en elak anv�ndare skapar eller f�r�ndrar befintliga SQL-kommandon f�r att exponera dolda data eller f�r att utf�ra farlig systemniv� kommandon p� webbsidan databas. [2]Detta g�rs genom att inmatad v�rden och kombinera med statiska parametrar f�r att bygga en SQL-fr�ga. 

inloggningsformul�ren har ingen validering, det man matar in i e-postadress och l�senord text rutan kontrolleras inte och man kontrollerar inte heller att e-postadress finns i databasen. Det finns valideringen p� att e-postadress text rutan ska var en e-postadress men inte mer �n s�, kunde logga in som Admin.

e-postadress: marco.villegas@live.se
l�senord:  ' or 0=0 -- 

Man kan ocks� skriva SQL injections i meddelade text rutan n�r man �r inloggad, vilket om man �r en elak anv�ndare kan betyda att man t�mmer hela anv�ndardatabasen eller kommer �t annat k�nsligt information.

Man kan sj�lv implementera en funktion som k�rs n�r meddelande formul�ret och inloggningsformul�ret skickas och kontrollerar om det inmatade tecken best�r av r�tt format och tecken l�ngd. [3] Men b�sta s�ttet f�r att hindra anv�ndare fr�n att g�ra SQL injections �r att anv�nda API som redan har f�rdiga skydd som automatiskt hittar SQL kod.

 
####Broken authentication and session management

[4]Applikationsfunktioner som r�r autentisering och sessionshantering �r fel implementerade, vilket g�r att en elak anv�ndare kan koma �t l�senord, nycklar, eller session token f�r att kunna ta �ver en anv�ndares identitet.

N�r man varit in loggad och sen loggar ut, s� fr�st�rs inte anv�ndarens session-data.  Skriver man in http://localhost:3000/message s� �r man inloggad som den som senast var in loggad. Vilket betyder att om admin inte logar ut och l�mnar dator s� kan en elak anv�ndare koma �t anv�ndarens konto s� l�nge den anv�nder samma dator. 

[5] h�lla all din session och autentisering relaterad information skyddad. B�sta setter �r att Uppfylla alla autentiserings och session kraven som anges i OWASP Application Security Verification Standard (ASVS) omr�den V2 (autentisering) och V3 (Session Management). Exmpel p� sessions funktion kan vara att den tar bort session n�r man logar ut och s�tter en sluts tid p� sessionen s� om anv�ndaren gl�mmer logga ut s� ta sessionen tas bort automatiskt efter en vis tid.

####Databas
[6]M�nga webbapplikationer skyddar inte k�nsliga data som kreditkortsnummer och autentiseringsuppgifter. Elaka anv�ndare kan stj�la eller �ndra s�dana svagt skyddade uppgifter f�r att genomf�ra brott. K�nsliga uppgifter skyddas extra mycket, som till exempel med kryptering till och fr�n databasen.
Som saker �r just nu s� kommer man �t databasen genom att ange dess s�kv�g.  http://localhost:3000/static/message.db. DB-filen �r okrypterad s� man kan �ppna den med word och se alla information utan n�gon st�rre sv�righet. Detta �ppnar upp f�r att elaka anv�ndare at kommer �t k�nslig information som de inte har r�tt till. Man kan ocks� koma �t alla meddelanden genom att skriva http://localhost:3000/message/data och f� ett Jason format fr�n databasen
 [7] man m�ste planera f�r attacker som kan komma inifr�n och fr�n externa anv�ndare. kryptera alla k�nsliga data som ska till och fr�n databasen, f�rvara inte k�nsliga uppgifter i on�dan man g�r b�st i att g�ra sig av med k�nslig data man inte anv�nder s� fort det anv�nds klart. 


####XSS 

[8]Webbapplikationer tar i mot op�litliga data och skickar det till webbl�saren utan ordentlig validering. Det kan l�ta en elak anv�ndare k�ra skript i offrets webbl�sare som kan kapa anv�ndarsessioner, vanst�lla webbplatser, eller omdirigera anv�ndaren till skadliga webbplatser.

Det finns ingen Validering p� meddelades text rutan n�r man �r inloggad, man kan skriva in javascript /HTML taggar men ocks� SQL-kod. Har testade <a href='#' onclick='alert("Hej mitt namn �r marco")'>Hej</a>

[9]Se till att endast till�ta en viss l�ngd av tecken och att tecken som ing�r i skript syntaxer tas bort, detta kommer att g�ra det om�jligt f�r webbapplikationen att se det som kod



###Optimering
####HTTP-caching 

[10]HTTP-caching �r n�r webbl�saren lagrar lokala kopior av webbresurser f�r snabbare h�mtning n�sta g�ng den beh�ver resursen. N�r en webbsida �r helt cachad kan webbl�saren v�ljer att inte kontakta servern alls och bara anv�nda sin egen cachad kopia. 

[11]Expires �r s�tt att kontroll s� att inte resurserna blir f�r gamla. Man setter ett datum fr�n vilket den cachade resursen inte l�ngre betraktas som giltigt. Fr�n detta datum s� kommer webbl�saren att beg�ra en ny kopia av resursen. Fram till dess s� anv�nder webbl�sare den lokal cachad kopia den har. 

Som det �r nu s� �r cachning�avst�ngd, webbsidan m�ste ladda hem alla filer varje g�ng man bes�ker sidan. Det g�r s� att man g�r on�digt m�nga HTTP-beg�ran och tar n�r prestandan. f�r att �ka prestandan s� b�r man startat caching och ange n�r inneh�ll g�r u /hur l�nge inneh�llet �r f�rskt.

####Strukturerar upp Kod
 [12]Javasscript borde s�ttas l�ngs ner vid slut body HTML tagen som det �r just nu s� �r Skripten placeras i sidans sidhuvud. Om script �r stort s� kan det ta tid att laddas in och orsakar on�dig laddningstid. Det kommer i sin tur att uppfattas av anv�ndaren som om sidan �r seg. [13]Jobbar man med ett projekt som inneh�ller mycket javascript-kod, kan det vara resurseffektivt att komprimera och minifiera sina javascript. 

Filernas storlek kan minskas avsev�rt vilket f�rst�s leder till en b�ttre och snabbare respons fr�n webbserverns sida. Css ska d�remot vara i sidhuvudet s� att det ladas in s� fort som m�jligt samt att man ska undvika att ha in line CSS i HTML kod som det �r nu. [14]minska on�dig HTTP requests genom att undvika att f�rs�ker h�mta en fil som inte finns eller inte kommer anv�ndas f�r det segar ner webbsidan, bootstrap.css ladas in men anv�nds inte av webbsidan. 

####Reflektioner
Tycker att den h�r labben varit en v�ldig l�rorik erfarenhet att l�s om det svagheter som fins �r en sak. Mena att testa och utforska de svagheter som finns �r en helt annan. 
Den h�r labben har f�t mig att t�nka p� s� m�nga saker vad g�ller min programmering. Saker som jag inte t�nkt p� tidigare, nu fr�st�r man b�ttre varf�r man ska t�nka p� s�kerhet. Det kr�vs inte mycket f�r n�gon att f�rst�ra n�got som kan ha tagit en flera m�nader eller till och med �r att bygga.  
Jag tror att man bara genom att f�rst� svagheterna som finns i systemen kan l�ras sig att skydda sig fr�n dem.  Vad g�ller optimering s� var det nysa saker blandat med gamla, som jag k�nner igen fr�n tidigare kurser. Optimeringen har f�t mig att t�nka p� vad jag har i min applikation och hur jag v�ljer at f�rvara och ladda in min kod. Samt t�nka p� caching vilket �r n�got jag inte t�nkt p� innan.  Alltid bra att repeteras saker och se saker fr�n andra perspektiv samt l�ras sig nya saker.    

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

