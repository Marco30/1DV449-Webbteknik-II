﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml.Linq;


namespace Weather.Domain
{
    public partial class Forecast// en partial klass som slås ihop med klassen som representerar all fällt i DB tabellen, som finns i DatamModel mappen
    {

        public Forecast(XElement day, int cityId, DateTime lastUpdate, DateTime nextUpdate)
        {
            CityID = cityId;
            Period = (int)day.Attribute("period");
            Temperature = (int)day.Element("temperature").Attribute("value");
            Symbol = (int)day.Element("symbol").Attribute("number");
            LastUpdate = lastUpdate;
            NextUpdate = nextUpdate;
        }
    }
}
