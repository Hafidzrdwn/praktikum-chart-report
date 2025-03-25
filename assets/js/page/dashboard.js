"use strict";

$(document).ready(function () {
  const base_url = "http://localhost:8080/praktikum/";
  // current path
  let path = window.location.pathname.substring(1).split("/");
  path.shift();
  path = path.join("/");

  if (path === "views/index.php") {
    const ctxBooksByCategory = document
      .getElementById("booksCategoryChart")
      .getContext("2d");
    const ctxBooksByYear = document
      .getElementById("booksYearChart")
      .getContext("2d");

    // 📊 Books per Category Chart
    if (ctxBooksByCategory) {
      $.ajax({
        url: `${base_url}chart.php`,
        type: "GET",
        data: { books_chart_category: true },
        dataType: "json",
        success: function (data) {
          const { books, totalData } = data;
          let categories = books.map((item) => item.category);
          let counts = books.map((item) => item.total);

          new Chart(ctxBooksByCategory, {
            type: "pie",
            data: {
              labels: categories,
              datasets: [
                {
                  label: "Total Buku",
                  data: counts,
                  backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0"],
                  borderWidth: 1,
                },
              ],
            },
            options: {
              maintainAspectRatio: false,
              responsive: true,
              plugins: {
                legend: {
                  position: "top",
                },
                datalabels: {
                  formatter: (value) => {
                    let percentage = ((value / totalData) * 100).toFixed(1);
                    return `${percentage}%`;
                  },
                  color: "#fff",
                  font: {
                    weight: "bold",
                  },
                },
              },
            },
            plugins: [ChartDataLabels],
          });
        },
      });
    }

    // 📊 Books per Year Chart
    if (ctxBooksByYear) {
      $.ajax({
        url: `${base_url}chart.php`,
        type: "GET",
        data: { books_year_chart: true },
        dataType: "json",
        success: function (data) {
          let years = data.map((item) => item.tahun_terbit);
          let counts = data.map((item) => item.total);

          new Chart(ctxBooksByYear, {
            type: "bar",
            data: {
              labels: years,
              datasets: [
                {
                  label: "Jumlah Buku",
                  data: counts,
                  backgroundColor: "rgba(54, 162, 235, 0.6)",
                  borderColor: "rgba(54, 162, 235, 1)",
                  borderWidth: 1,
                },
              ],
            },
            options: {
              responsive: true,
              scales: { y: { beginAtZero: true } },
            },
          });
        },
      });
    }
  }
});

// $('#visitorMap').vectorMap(
// {
//   map: 'world_en',
//   backgroundColor: '#ffffff',
//   borderColor: '#f2f2f2',
//   borderOpacity: .8,
//   borderWidth: 1,
//   hoverColor: '#000',
//   hoverOpacity: .8,
//   color: '#ddd',
//   normalizeFunction: 'linear',
//   selectedRegions: false,
//   showTooltip: true,
//   pins: {
//     id: '<div class="jqvmap-circle"></div>',
//     my: '<div class="jqvmap-circle"></div>',
//     th: '<div class="jqvmap-circle"></div>',
//     sy: '<div class="jqvmap-circle"></div>',
//     eg: '<div class="jqvmap-circle"></div>',
//     ae: '<div class="jqvmap-circle"></div>',
//     nz: '<div class="jqvmap-circle"></div>',
//     tl: '<div class="jqvmap-circle"></div>',
//     ng: '<div class="jqvmap-circle"></div>',
//     si: '<div class="jqvmap-circle"></div>',
//     pa: '<div class="jqvmap-circle"></div>',
//     au: '<div class="jqvmap-circle"></div>',
//     ca: '<div class="jqvmap-circle"></div>',
//     tr: '<div class="jqvmap-circle"></div>',
//   },
// });

// // weather
// getWeather();
// setInterval(getWeather, 600000);

// function getWeather() {
//   $.simpleWeather({
//   location: 'Bogor, Indonesia',
//   unit: 'c',
//   success: function(weather) {
//     var html = '';
//     html += '<div class="weather">';
//     html += '<div class="weather-icon text-primary"><span class="wi wi-yahoo-' + weather.code + '"></span></div>';
//     html += '<div class="weather-desc">';
//     html += '<h4>' + weather.temp + '&deg;' + weather.units.temp + '</h4>';
//     html += '<div class="weather-text">' + weather.currently + '</div>';
//     html += '<ul><li>' + weather.city + ', ' + weather.region + '</li>';
//     html += '<li> <i class="wi wi-strong-wind"></i> ' + weather.wind.speed+' '+weather.units.speed + '</li></ul>';
//     html += '</div>';
//     html += '</div>';

//     $("#myWeather").html(html);
//   },
//   error: function(error) {
//     $("#myWeather").html('<div class="alert alert-danger">'+error+'</div>');
//   }
//   });
// }
