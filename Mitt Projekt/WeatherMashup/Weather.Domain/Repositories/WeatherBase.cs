using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain.Repositories
{
    public abstract class WeatherBase : IWeather
    {
        public abstract IEnumerable<City> FindCityByName(string cityName);
        public abstract void AddCity(IEnumerable<City> city);
        public abstract City FindCityById(int id);
        public abstract IEnumerable<Forecast> FindForecast(int id);
        public abstract void AddForecast(IEnumerable<Forecast> forecast);
        public abstract void DeleteForecast(IEnumerable<Forecast> forecast);

        public abstract void Save();

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
