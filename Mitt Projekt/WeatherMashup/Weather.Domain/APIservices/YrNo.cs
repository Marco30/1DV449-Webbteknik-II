using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;
using System.Xml;
using System.Xml.Linq;

namespace Weather.Domain.APIservices
{
    public class YrNO : IYrNo
    {

        public bool YrNoAPIResponseTest()// YRNO API funktion som tästar om API funkar 
        {
            try
            {
                string APITest = "http://www.yr.no/sted/Sverige/stockholm/huddinge/forecast.xml";
                XDocument xDoc = XDocument.Load(APITest);

                return true;

            }
            catch (Exception e)
            {
                return false;
            }
        }

        public IEnumerable<Forecast> GetForecast(City city)// YRNO API funktion, hämtar alla väder prognoser som matchar platsen man söker på
        {
            XElement xml = XElement.Load("http://www.yr.no/sted/" + city.Country + "/" + city.Region + "/" + city.Name + "/forecast.xml");

            var xmlYrNo = xml.Element("forecast").Element("tabular").Elements("time");

            List<Forecast> list = new List<Forecast>();

            DateTime today = DateTime.Now;

            foreach (XElement day in xmlYrNo)
            {
                DateTime lastUpdate = FixesTheDate((string)day.Attribute("from"));
                DateTime nextUpdate = FixesTheDate((string)day.Attribute("to"));

                if (lastUpdate > today && lastUpdate < today.AddDays(5))
                {
                    list.Add(new Forecast(day, city.CityID, lastUpdate, nextUpdate));
                }
            }

            return list;
        }

        public DateTime FixesTheDate(string dateTime)//funtion som redigera XML filsen tid data vi får 
        {
            var dateSplit = dateTime.Split('T');
            string date = dateSplit[0];
            string time = dateSplit[1];

            string correct = date + " " + time;

            DateTime stringToDateTime = Convert.ToDateTime(correct);
            return stringToDateTime;
        }

   

    }
}
