"use strict";

$(document).ready(function () {
  const base_url = "http://localhost:8080/praktikum/";
  // current path
  let path = window.location.pathname.substring(1).split("/");
  path.shift();
  path = path.join("/");

  if (path === "views/penjualan/rekap.php") {
    const ctxSellingMonth = document
      .getElementById("sellingMonthChart")
      .getContext("2d");
    const ctxCustomerArea = document
      .getElementById("customerAreaChart")
      .getContext("2d");

    if (ctxSellingMonth) {
      $.ajax({
        url: `${base_url}views/penjualan/proses_penjualan.php`,
        method: "GET",
        data: { selling_month: true },
        success: function (response) {
          let labels = response.map((item) => item.bulan); 
          let data = response.map((item) => item.total_penjualan);

          new Chart(ctxSellingMonth, {
            type: "line",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Jumlah Buku Terjual",
                  data: data,
                  borderColor: "rgba(54, 162, 235, 1)",
                  backgroundColor: "rgba(54, 162, 235, 0.2)",
                  borderWidth: 2,
                  fill: true,
                  tension: 0.4,
                },
              ],
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true,
                },
              },
            },
          });
        },
        error: function (xhr, status, error) {
          console.error("Error fetching sales data:", error);
        },
      });
    }

    if (ctxCustomerArea) {
      $.ajax({
        url: `${base_url}views/penjualan/proses_penjualan.php`,
        method: "GET",
        data: { customer_area: true },
        success: function (response) {
          let labels = response.map((item) => item.provinsi); 
          let data = response.map((item) => item.total_pembeli); 

          new Chart(ctxCustomerArea, {
            type: "pie",
            data: {
              labels: labels,
              datasets: [
                {
                  label: "Jumlah Kustomer",
                  data: data,
                  backgroundColor: [
                    "#FF6384",
                    "#36A2EB",
                    "#FFCE56",
                    "#4BC0C0",
                    "#9966FF",
                    "#FF9F40",
                    "#66ff66",
                    "#ff6666",
                  ],
                },
              ],
            },
            options: {
              maintainAspectRatio: false,
              responsive: true,
              plugins: {
                legend: {
                  position: "bottom",
                },
              },
            },
          });
        },
        error: function (xhr, status, error) {
          console.error("Error fetching customer data:", error);
        },
      });
    }
  }
});
