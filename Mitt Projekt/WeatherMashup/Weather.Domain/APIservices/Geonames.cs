using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Web;

namespace Weather.Domain.APIservices
{
    public class Geonames : IGeonames
    {
        public IEnumerable<City> GetCity(string cityName)
        {
            string JsonRaw;

            var requestUrlString = String.Format("http://api.geonames.org/searchJSON?name=" + cityName + "&maxRows=50&username=marco3030");
            var request = (HttpWebRequest)WebRequest.Create(requestUrlString);

            using (var response = request.GetResponse())
            using (var reader = new StreamReader(response.GetResponseStream()))
            {
                JsonRaw = reader.ReadToEnd();
            }

            var lengthToStart = JsonRaw.IndexOf("[");
            var lengthRawJson = JsonRaw.Length;
            var contentRawJson = JsonRaw.Substring(lengthToStart, lengthRawJson - lengthToStart - 1);

            return JArray.Parse(contentRawJson).Select(city => new City(city)).ToList();
        }
    }
}
