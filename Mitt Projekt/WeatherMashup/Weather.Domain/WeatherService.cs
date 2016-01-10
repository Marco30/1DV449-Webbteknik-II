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

        public override IEnumerable<City> GetCity(string cityName)
        {
            //
            IEnumerable<City> city;
            //

            if (_geonameAPIservice.GeonamesAPIResponseTest() == false)
            {
                //

               city = _repository.FindCityByName(cityName);

                //

            }

            else
            {
              
               city = _repository.FindCityByName(cityName);

                if (city.Count() == 0)
                {
                    city = _geonameAPIservice.GetCity(cityName);

                    _repository.AddCity(city);
                    _repository.Save();
                }
            }

            return city;
        }

        public override City FindCity(int id)
        {
            return _repository.FindCityById(id);
        }

        public override IEnumerable<Forecast> GetForecast(City city)
        {

            IEnumerable<Forecast> forecast;
            
            //
            if (_yrnoAPIservice.YrNoAPIResponseTest() == false)
            {
            //
                forecast = _repository.FindForecast(city.CityID);

            //
            }
            else
            {
               
                forecast = _repository.FindForecast(city.CityID);

                if (forecast.Count() == 0)
                {
                    forecast = _yrnoAPIservice.GetForecast(city);
                    _repository.AddForecast(forecast);
                    _repository.Save();
                }
                else
                {
                    foreach (Forecast item in forecast)
                    {
                        if (item.NextUpdate < DateTime.Now)
                        {
                            _repository.DeleteForecast(forecast);
                            _repository.Save();

                            forecast = _yrnoAPIservice.GetForecast(city);

                            _repository.AddForecast(forecast);
                            _repository.Save();
                            break;
                        }
                    }
                }

            }
            //
            return forecast;
        }

        //test 
        public override bool GResponseTest()
        {

            if (_geonameAPIservice.GeonamesAPIResponseTest() == true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        //
        public override bool YResponseTest()
        {

            if (_yrnoAPIservice.YrNoAPIResponseTest() == true)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        //

        protected override void Dispose(bool disposing)
        {
            _repository.Dispose();
            base.Dispose(disposing);
        }
    }
}
