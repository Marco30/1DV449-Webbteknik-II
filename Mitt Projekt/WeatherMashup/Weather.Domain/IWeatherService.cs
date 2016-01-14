using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain
{
    public interface IWeatherService : IDisposable// min interface, IDisposable används för att rensa upp ohanterade resurser, Ohanterade resurser är till exempel, öppna filer, Öppna nätverksanslutningar, Datorstyrda minne
    {
        //klasser som implementerar interfacen funktionaliteten kan använda interfacens egenskaper, metoder och/eller händelser. 
        //interface i C# är ett sätt att komma runt bristen på multipelt arv i C #, vilket innebär att man inte inte kan ärva från flera klasser C# men du kan inplämnetar flera gränssnitt istället i C#.
        IEnumerable<City> GetCity(string cityName);
        City FindCity(int id);
        IEnumerable<Forecast> GetForecast(City city);

        bool GResponseTest();
        bool YResponseTest();
    }
}
