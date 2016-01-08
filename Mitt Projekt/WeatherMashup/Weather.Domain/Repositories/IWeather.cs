using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain.Repositories
{
    public interface IWeather : IDisposable//min interface, IDisposable används för att rensa upp ohanterade resurser, Ohanterade resurser är till exempel, öppna filer, Öppna nätverksanslutningar, Datorstyrda minne
    {
        //Marco: bra att repetera 
        //klasser som implementerar interfacen funktionaliteten kan använda interfacens egenskaper, metoder och/eller händelser. 
        //interface i C# är ett sätt att komma runt bristen på multipelt arv i C #, vilket innebär att man inte inte kan ärva från flera klasser C# men du kan inplämnetar flera gränssnitt istället i C#.
        IEnumerable<City> FindCityByName(string cityName);// hittar staden i tabelen city
        City FindCityById(int id);// hittar staden med hjälp av ID i tabelen city
        IEnumerable<Forecast> FindForecast(int id);// hittar väderprognos med hjälav av ID
        void AddCity(IEnumerable<City> city);// Lägger till stad i city tabelen 
        void AddForecast(IEnumerable<Forecast> forecast);// Lägger till väderprognos i forecast tabelen 
        void DeleteForecast(IEnumerable<Forecast> forecast);// tar bort väderprognos från forecast tabelen 
        void Save();
    }
}
