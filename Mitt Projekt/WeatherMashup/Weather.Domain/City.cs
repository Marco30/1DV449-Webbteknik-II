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
            Name = cityToken.Value<string>("name");
            Region = cityToken.Value<string>("adminName1");
            Country = cityToken.Value<string>("countryName");
        }
    }
}
