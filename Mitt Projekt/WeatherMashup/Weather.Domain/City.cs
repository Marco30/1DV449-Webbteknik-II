using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain
{
    public partial class City// en partial klass som slås ihop med klassen som representerar all fällt i DB tabellen, som finns i DatamModel mappen
    {
  
        public City(JToken JasonCity)
        {
            string NLength = JasonCity.Value<string>("name");
            Name = (NLength.Length > 30) ? NLength.Substring(0, 25) + "." : NLength;
            Region = JasonCity.Value<string>("adminName1");
            Country = JasonCity.Value<string>("countryName");
        }
    }
}
