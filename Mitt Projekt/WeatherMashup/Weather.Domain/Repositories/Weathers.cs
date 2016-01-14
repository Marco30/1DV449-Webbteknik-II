using System;
using System.Collections.Generic;
using System.Data.Entity;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Weather.Domain; 

namespace Weather.Domain.Repositories
{
    public class Weathers : WeatherBase
    {

        private Marco_MashupEntities _context = new Marco_MashupEntities();

        public override IEnumerable<City> FindCityByName(string cityName)//söker igenom databas med hjäp av stadens namn
        {
            //söker igenom tabellerna 
            var findCity = from city in _context.Cities.ToList()
                           where city.Name.ToLower().Contains(cityName.ToLower())
                           select city;

            return findCity;
        }
        
        
        public override void AddCity(IEnumerable<City> city)// läger till i stad 
        {
            foreach (City item in city)
            {
                _context.Cities.Add(item);// kallar på fukntion i EntityFramework som läger till ny kontakt 
            }
        }


        public override City FindCityById(int id)// hämtar stad utifrån ID
        {
            return _context.Cities.Find(id);// hämtar kontkat med ID frpn databasen
        }

        public override IEnumerable<Forecast> FindForecast(int id)// hittar väderprognos med hjälp av ID 
        {
            //söker igenom tabellerna 
            var findForecast = from forecast in _context.Forecasts.ToList()
                               where forecast.CityID == id
                               select forecast;

            return findForecast;
        }

        public override void AddForecast(IEnumerable<Forecast> forecast)//läger till väderprognos
        {
            foreach (Forecast item in forecast)
            {
                _context.Forecasts.Add(item);// kallar på fukntion i EntityFramework som läger till ny väderprognos
            }
        }

        public override void DeleteForecast(IEnumerable<Forecast> forecast)// tar bort väderprogrnos
        {
            foreach (Forecast item in forecast)
            {
                if (_context.Entry(item).State == EntityState.Detached)// kontrolerar om Entity är detached för att attacha den 
                {
                    _context.Forecasts.Attach(item);// attachar data till DataContext 
                }

                _context.Forecasts.Remove(item);// kallar på fukntion i EntityFramework som tar bort väderprognos
            }
        }

        public override void Save()// spara
        {
            _context.SaveChanges();// kallar på fukntion i EntityFramework som sparar ändringar till databasen  
        }
    }
}
