//------------------------------------------------------------------------------
// <auto-generated>
//     This code was generated from a template.
//
//     Manual changes to this file may cause unexpected behavior in your application.
//     Manual changes to this file will be overwritten if the code is regenerated.
// </auto-generated>
//------------------------------------------------------------------------------

namespace Weather.Domain
{
    using System;
    using System.Collections.Generic;
    
    public partial class City
    {
        /*public City()
        {
            this.Forecasts = new HashSet<Forecast>();
        }*/
    
        public int CityID { get; set; }
        public string Name { get; set; }
        public string Region { get; set; }
        public string Country { get; set; }
    
        public virtual ICollection<Forecast> Forecasts { get; set; }
    }
}