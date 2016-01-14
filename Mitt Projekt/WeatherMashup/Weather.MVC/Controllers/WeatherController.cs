using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

using Weather.MVC.ViewModel;
using Weather.Domain;
using Weather.Domain.APIservices;

namespace Weather.MVC.Controllers
{
    public class WeatherController : Controller
    {
        private Weather.Domain.IWeatherService _service;

        public WeatherController()
            : this(new WeatherService())
        {
        }

        public WeatherController(Weather.Domain.IWeatherService service)
        {
            _service = service;
        }

      
        public ActionResult Index()
        {
            return View();
        }

      
        [HttpPost]
        //[ValidateAntiForgeryToken]
        // @Html.AntiForgeryToken()
        public ActionResult Index([Bind(Include = "CityName")] WeatherViewModel model)//post funktion som tar med sig söknignen man gjort 
        {
            try// Felhantering 
            {
                if (ModelState.IsValid)// kontrollärar validering 
                {
                    model.Citys = _service.GetCity(model.CityName);// funtion som söker efter staden man sökt på 

                    if (model.Citys.Count() == 0)// inga sökningar hittas 
                    {
                        TempData["noCities"] = "Inga städer hittades med namnet " + model.CityName + "!";
                    }
                    if (_service.GResponseTest() == false)// API är ner 
                    {
                        TempData["noCities"] = "API Geonames tjänsten ligger för tillfället nere, Sökning har skett i vår databas, Om sökningen inte finns i vår databas så visas inget";
                    }
                }
            }
            catch (Exception ex)
            {
                ModelState.AddModelError(String.Empty, ex.Message);
            }

            return View(model);
        }

        public ActionResult Weather(int id, WeatherViewModel model)// söker efter väderprognoser 
        {
            try
            {
                model.City = _service.FindCity(id);//lättar efters prognoser til den valda staden  

                if (model.City == null)// ingen stad finn i databasen eller i API 
                {
                    return View("Error");
                }

                //
                if (_service.YResponseTest() == false)// API är ner 
                {
                    TempData["noForecast"] = "YrNo Geonames tjänsten ligger för tillfället nere, Sökning har skett i vår databas, Om sökningen inte finns i vår databas så visas ingets";
                   
                    model.Forecasts = _service.GetForecast(model.City);// visar resultat av söking från databas 

                    return View(model);
                }
                //
                model.Forecasts = _service.GetForecast(model.City);// visar resultat av söking 

            }
            catch (Exception)
            {
                return View("Error");
            }

            return View(model);
        }
    }
}