using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain
{
    public abstract class WeatherServiceBase : IWeatherService
    {
        public abstract IEnumerable<City> GetCity(string cityName);

        public abstract City FindCity(int id);
        public abstract IEnumerable<Forecast> GetForecast(City city);

        public abstract bool GResponseTest();

        public abstract bool YResponseTest();

        protected virtual void Dispose(bool disposing)
        {
        }
        public void Dispose()
        {
            Dispose(true);
            GC.SuppressFinalize(this);
        }
    }
}
