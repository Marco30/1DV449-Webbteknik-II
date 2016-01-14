using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Web;
using Weather.Domain;


namespace Weather.MVC.ViewModel
{
    public class WeatherViewModel
    {
        [DisplayName("Välj stad:")]// label som visas brevid sökinges rutan 
        [Required(ErrorMessage = "Fältet får inte vara tomt - välj stad!")]// kontrollerar om textrutan FirstNamn är tom  
        [StringLength(20, ErrorMessage = "sökningen kan innehålla högst 20 tecken!!!")]// kontrollerar om den inmatade texten är mer än 20 täcken   
        public string CityName { get; set; }

        public int counter;

        public bool HasCity
        {
            get { return Citys != null && Citys.Any(); }
        }

        public bool HasForcast
        {
            get { return Forecasts != null && Forecasts.Any(); }
        }

        public string GetDayOfTheWeek(DateTime dateTime, int period)// funktions som kontrolerar om väder prognonsernas dag 
        {
            var culture = new System.Globalization.CultureInfo("sv-SE");

            if (dateTime.DayOfWeek == DateTime.Now.DayOfWeek && counter != 1)
            {
                //counter = 1; test 
                /* 
                 if (dateTime.DayOfWeek == DateTime.Now.AddDays(1).DayOfWeek && period == 0)
            {
                return "Imorgon";
            }*/
                counter = 1;
                return "Idag";

            }
            if (dateTime.DayOfWeek == DateTime.Now.AddDays(1).DayOfWeek && period == 0)
            {
                return "Imorgon";
            }
            if (period == 0)
            {

                return culture.DateTimeFormat.GetDayName(dateTime.DayOfWeek).ToString();
            }
            else
            {
                return null;
            }
        }

        public IEnumerable<City> Citys { get; set; }

        public City City { get; set; }

        public IEnumerable<Forecast> Forecasts { get; set; }
    }
}
