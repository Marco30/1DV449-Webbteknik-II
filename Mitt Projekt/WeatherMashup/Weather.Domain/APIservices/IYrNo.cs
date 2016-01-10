using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Weather.Domain.APIservices
{
    public interface IYrNo
    {
        IEnumerable<Forecast> GetForecast(City city);
        DateTime FixesTheDate(string date);

        bool YrNoAPIResponseTest();
    }
}
