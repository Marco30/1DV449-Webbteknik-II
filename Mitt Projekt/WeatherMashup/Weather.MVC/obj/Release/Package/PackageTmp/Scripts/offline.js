"use strict";

var MinOffline =
    {
        start: function ()
        {
            var keepGoing = true;

            if (MinOffline.checkJSNetConnection() == true)//alert("Internet Connection Exists");
            {
                
                
            }
            else//alert("Internet Connection Doesn't Exist");
            {
                
                window.location = "http://vhost9.lnu.se:20081/1dv409/mv222fp/IndexOffline.html";
                keepGoing = false;
            }

            if (keepGoing)
            {
                setTimeout(MinOffline.start, 2000); //10 secunder = 10000
            }

        },

        checkJSNetConnection: function ()
        {
            var xhr = new XMLHttpRequest();
            //var file = "http://vhost9.lnu.se:20081/1dv409/mv222fp/Marco.png";
            var file = "http://vhost9.lnu.se:20081/1dv409/mv222fp/olinetest.html";
            var r = Math.round(Math.random() * 10000);
            xhr.open('HEAD', file + "?subins=" + r, false);
            try
            {
                xhr.send();
                if (xhr.status >= 200 && xhr.status < 304)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (e)
            {
                return false;
            }
        },

    };

window.onload = MinOffline.start;// startar funktionen som har label start när sidan har ladats