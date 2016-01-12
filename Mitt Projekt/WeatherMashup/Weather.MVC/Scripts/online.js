"use strict";

var GetOnline =
    {
        start: function ()
        {
            var keepGoing = true;

            if (GetOnline.checkJSNetConnection() == true)//alert("Internet Connection Exists");
            {
                
                window.location = "http://vhost9.lnu.se:20081/1dv409/mv222fp";
                keepGoing = false;
            }
            else//alert("Internet Connection Doesn't Exist");
            {
                
                
            }

            if (keepGoing)
            {
                setTimeout(GetOnline.start, 2000); //10 secunder = 10000
            }


        },

        checkJSNetConnection: function ()
        {
            var xhr = new XMLHttpRequest();
            var file = "http://vhost9.lnu.se:20081/1dv409/mv222fp/Marco.png";
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

window.onload = GetOnline.start;// startar funktionen som har label start när sidan har ladats