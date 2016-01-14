using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Weather.Domain.Repositories;
using Weather.Domain.APIservices;

namespace Weather.Domain
{
    public class WeatherService : WeatherServiceBase
    {
        private IWeather _repository;
        private IGeonames _geonameAPIservice;
        private IYrNo _yrnoAPIservice;
         public WeatherService()
            : this(new Weathers(), new Geonames(), new YrNO())
        {
        }

        public WeatherService(IWeather repository, IGeonames geonameAPIservice, IYrNo yrnoAPIservice)
        {
            _repository = repository;
            _geonameAPIservice = geonameAPIservice;
            _yrnoAPIservice = yrnoAPIservice;
        }

        public override IEnumerable<City> GetCity(string cityName)// fukntion som söker i dattabasen eller API 
        {
            //
            IEnumerable<City> city;
            //

            if (_geonameAPIservice.GeonamesAPIResponseTest() == false)// om api är nere så söker man i databasen 
            {
                //

               city = _repository.FindCityByName(cityName);// söker i database 

                //

            }

            else// api funkar 
            {
              
               city = _repository.FindCityByName(cityName);// kontrlerar för som sökningen redan finns i databasen 

               if (city.Count() == 0)// inget matchar sökningen i databasen
                {
                    city = _geonameAPIservice.GetCity(cityName);// söker hos APIen

                    _repository.AddCity(city);// kalar på funktion som ska läga till stad i databasen
                    _repository.Save();// kalar på funktion som ska spara ändringar till databasen 
                }
            }

            return city;
        }

        public override City FindCity(int id)// lättar efter stad med hjälp av id i databasen 
        {
            return _repository.FindCityById(id);
        }

        public override IEnumerable<Forecast> GetForecast(City city)// fukntion som söker i dattabasen eller API 
        {

            IEnumerable<Forecast> forecast;
            
            //
            if (_yrnoAPIservice.YrNoAPIResponseTest() == false)// om api är nere så söker man i databasen 
            {
            //
                forecast = _repository.FindForecast(city.CityID);// söker i databas 

            //
            }
            else// api funkar 
            {

                forecast = _repository.FindForecast(city.CityID);// söker i databas 

                if (forecast.Count() == 0)// fins inte i databas 
                {
                    forecast = _yrnoAPIservice.GetForecast(city);// söker i API
                    _repository.AddForecast(forecast);// läger till i databas 
                    _repository.Save();// sparar datan till databas 
                }
                else// kontrolerar om väder datan fortfarande är aktuell 
                {
                    foreach (Forecast item in forecast)// lopar igen och kontroelrar dataum
                    {
                        if (item.NextUpdate < DateTime.Now)// if satsen körs om datum är gammal 
                        {
                            _repository.DeleteForecast(forecast);// tar bort från databasen 
                            _repository.Save();//sparar ändringen  

                            forecast = _yrnoAPIservice.GetForecast(city);// söker efter aktuell  data i API

                            _repository.AddForecast(forecast);// kalar på funktion som ska läga till stad i databasen
                            _repository.Save();//kalar på funktion som sparar datan till databasen 
                            break;
                        }
                    }
                }

            }
            //
            return forecast;
        }

        //test 
        public override bool GResponseTest()// Funktion som kontrollerar om Geonames API är nere 
        {

            if (_geonameAPIservice.GeonamesAPIResponseTest() == true)
            {
                return true;// funkar
            }
            else
            {
                return false;// är nere 
            }
        }

        //
        public override bool YResponseTest()// Funktion som kontrollerar om YrNo API är nere 
        {

            if (_yrnoAPIservice.YrNoAPIResponseTest() == true)
            {
                return true;// funkar
            }
            else
            {
                return false;// är nere 
            }
        }

        //

        protected override void Dispose(bool disposing)// används för att frigöra Ohanterade resurser 
        {
            _repository.Dispose();
            base.Dispose(disposing);
        }
    }
}
