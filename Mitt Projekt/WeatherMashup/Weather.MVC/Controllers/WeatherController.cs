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

        // Get: City
        public ActionResult Index()
        {
            return View();
        }

        // Post: City
        [HttpPost]
        //[ValidateAntiForgeryToken]
        public ActionResult Index([Bind(Include = "CityName")] WeatherViewModel model)
        {
            try
            {
                if (ModelState.IsValid)
                {
                    model.Citys = _service.GetCity(model.CityName);
                    if (model.Citys.Count() == 0)
                    {
                        TempData["noCities"] = "Inga städer hittades med namnet " + model.CityName + "!";
                    }
                    if (_service.GResponseTest() == false)
                    {
                        TempData["noCities"] = "API Geonames tjänsten ligger för tillfället nere, Sökning har skett i vår databas, Om din ort inte finns i vår databas kommer det inte vissas";
                    }
                }
            }
            catch (Exception ex)
            {
                ModelState.AddModelError(String.Empty, ex.Message);
            }

            return View(model);
        }

        // Get: Weather
        public ActionResult Weather(int id, WeatherViewModel model)
        {
            try
            {
                model.City = _service.FindCity(id);

                if (model.City == null)
                {
                    return View("Error");
                }

                //
                if (_service.YResponseTest() == false)
                {
                    TempData["noForecast"] = "YrNo Geonames tjänsten ligger för tillfället nere, Sökning har skett i vår databas, Om din ort inte finns i vår databas kommer det inte vissas";
                   
                    model.Forecasts = _service.GetForecast(model.City);

                    return View(model);
                }
                //
                model.Forecasts = _service.GetForecast(model.City);

            }
            catch (Exception)
            {
                return View("Error");
            }

            return View(model);
        }
    }
}