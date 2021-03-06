﻿using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;

namespace Weather.Domain.Entities
{
    /// <summary>
    /// Place form GeoNames
    /// </summary>
    public class Place
    {
        [Key]
        public int PlaceId { get; set; }

        [Required]
        [StringLength(100)]
        public string Name { get; set; }

        [Required]
        [StringLength(100)]
        public string Region { get; set; }

        [Required]
        [StringLength(100)]
        public string Country { get; set; }

        [Required]
        public double Latitude { get; set; }

        [Required]
        public double Longitude { get; set; }

        [Required]
        public DateTime NextUpdate { get; set; }

        [Required]
        public int SearchId { get; set; }

        public virtual ICollection<Forecast> Forecasts { get; set; }

        public virtual Search Search { get; set; }

        public Place()
        {
            this.Forecasts = new HashSet<Forecast>();
        }
    }
}
