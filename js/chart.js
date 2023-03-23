// Chart Data
var chartData = [
  {
    label: "Venezuela",
    value: "290",
  },
  {
    label: "Saudi",
    value: "260",
  },
  {
    label: "Canada",
    value: "180",
  },
  {
    label: "Iran",
    value: "140",
  },
  {
    label: "Russia",
    value: "115",
  },
  {
    label: "UAE",
    value: "100",
  },
  {
    label: "US",
    value: "30",
  },
  {
    label: "China",
    value: "30",
  },
];

// Chart Configurations
var chartConfig = {
  chart: {
    caption: "Countries With Most Oil Reserves [2017-18]",
    subCaption: "In MMbbl = One Million barrels",
    xAxisName: "Country",
    yAxisName: "Reserves (MMbbl)",
    numberSuffix: "K",
    theme: "fusion",
    exportEnabled: "1",
  },
  data: chartData,
};

// <-- Page Switching -->
// Get the current page URL
const currentUrl = window.location.href;

// Get the link elements
const page1Link = document.getElementById("my_dashboard-link");
const page2Link = document.getElementById("dashboard-link");

// Check which link matches the current page URL
if (currentUrl.includes("my_dashboard.php")) {
  page1Link.classList.add("active-link");
} else if (currentUrl.includes("dashboard.php")) {
  page2Link.classList.add("active-link");
}

// <-- Add Chart Function -->

$(document).ready(function () {
  var chartCount = $(".chart-container").length; //takes the current amount of charts in the document + 1 (includes the chart we're creating).

  $("#addChart").click(function () {
    var newChartContainer = $("<div>", { class: "chart-container" });
    var newChartDiv = $("<div>", { id: "chart-" + chartCount }).text(
      "Chart Should Load Here..."
    );

    var newChartDelete = $("<button>", { id: "chartDelete" }).text("Delete");

    newChartContainer.append(newChartDiv, newChartDelete);
    $("#charts").append(newChartContainer);

    var chart = new FusionCharts({
      type: "bar2d",
      renderAt: "chart-" + chartCount,
      width: "100%",
      height: "100%",
      dataFormat: "json",
      dataSource: chartConfig,
    });

    chart.render();
    chartCount++;
  });
});

// <-- Delete Chart Function -->

function removeFlexItem(event) {
  const button = $(event.target);
  const container = button.closest(".chart-container");
  container.remove();
}

$(document).ready(function () {
  $("#charts").on("click", ".chart-container button", removeFlexItem);
});
