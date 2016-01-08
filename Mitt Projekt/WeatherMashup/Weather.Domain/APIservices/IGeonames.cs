using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain.APIservices
{
    public interface IGeonames
    {
        IEnumerable<City> GetCity(string cityName);
    }
}
