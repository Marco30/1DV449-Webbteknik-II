using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain
{
    public abstract class WeatherServiceBase : IWeatherService
    {
        //bra at veta 
        //De viktigaste skillnaderna mellan ett gränssnitt och en abstrakt klass är att en abstrakt klass kan tillhandahålla implementerade metoder. 
        //Med gränssnitt kan du bara deklarera metoder, Abstrakta klasser kan du lägga till grund beteende
        // en astrakt klaass skapar struktur och fasta ramar att röra sig inom 
      
        public abstract IEnumerable<City> GetCity(string cityName);

        public abstract City FindCity(int id);
        public abstract IEnumerable<Forecast> GetForecast(City city);

        public abstract bool GResponseTest();//testar om genom APi är ner 

        public abstract bool YResponseTest();//testar om YR APi är ner 

        protected virtual void Dispose(bool disposing)// den här dipos sätta sig över den atomat genererade Dispose som brukar finnas i controllers 
        {
        }
        public void Dispose()// den här dipos sätta sig över den atomat genererade Dispose som brukar finnas i controllers 
        {
            //IDisposable används för att rensa upp ohanterade resurser, Ohanterade resurser är till exempel, öppna filer, Öppna nätverksanslutningar, Datorstyrda minne
            Dispose(true);
            GC.SuppressFinalize(this);
        }
    }
}
