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
            var city = _repository.FindCityByName(cityName);

            if (city.Count() == 0)
            {
                city = _geonameAPIservice.GetCity(cityName);

                _repository.AddCity(city);
                _repository.Save();
            }

            return city;
        }

  
    }
}
