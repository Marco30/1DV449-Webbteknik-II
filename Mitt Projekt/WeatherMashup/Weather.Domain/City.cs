using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain
{
    public partial class City
    {
       public City()
        {
            this.Forecasts = new HashSet<Forecast>();
        }
        public City(JToken cityToken)
        {
            string NLength = cityToken.Value<string>("name");
            Name = (NLength.Length > 30) ? NLength.Substring(0, 25) + "." : NLength;
            Region = cityToken.Value<string>("adminName1");
            Country = cityToken.Value<string>("countryName");
        }
    }
}
