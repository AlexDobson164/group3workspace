function removeFlexItem(event) {
    const button = event.target;
    const container = button.closest(".chart-container");
    container.parentElement.removeChild(container);
}

function addChartContainer() {

    const flexContainer = document.querySelector(".flex-container");
    const chartSelector = document.getElementById("graph-selector");
    const ChartContainer = document.createElement("div");
    ChartContainer.classList.add("chart-container");

    const chart = document.createElement("div");
    chart.classList.add("chart");
    chart.textContent = chartSelector.value;
    ChartContainer.appendChild(chart);

    const button = document.createElement("button");
    button.textContent = "Delete";
    ChartContainer.appendChild(button);

    button.addEventListener("click", removeFlexItem);
    flexContainer.appendChild(ChartContainer);
}

const chartData = [
    {
      label: "Venezuela",
      value: "290"
    },
    {
      label: "Saudi",
      value: "260"
    },
    {
      label: "Canada",
      value: "180"
    },
    {
      label: "Iran",
      value: "140"
    },
    {
      label: "Russia",
      value: "115"
    },
    {
      label: "UAE",
      value: "100"
    },
    {
      label: "US",
      value: "30"
    },
    {
      label: "China",
      value: "30"
    }
  ];

  // Create a JSON object to store the chart configurations
const chartConfig1 = {
    //Specify the chart type
    type: "column2d",
    //Set the container object
    renderAt: "chart-container",
    //Specify the width of the chart
    width: "100%",
    //Specify the height of the chart
    height: "400",
    //Set the type of data
    dataFormat: "json",
    dataSource: {
      chart: {
        //Set the chart caption
        caption: "Countries With Most Oil Reserves [2017-18]",
        //Set the chart subcaption
        subCaption: "In MMbbl = One Million barrels",
        //Set the x-axis name
        xAxisName: "Country",
        //Set the y-axis name
        yAxisName: "Reserves (MMbbl)",
        numberSuffix: "K",
        //Set the theme for your chart
        theme: "fusion"
      },
      // Chart Data from Step 2
      data: chartData
    }
  };
  FusionCharts.ready(function() {
    new FusionCharts({
      ...chartConfig1,
      renderAt: "chart1",
    }).render();
  });

const chartData2 = [
  {
    label: "Venezuela",
    value: "290"
  },
  {
    label: "Saudi",
    value: "260"
  },
  {
    label: "Canada",
    value: "180"
  },
  {
    label: "Iran",
    value: "140"
  },
  {
    label: "Russia",
    value: "115"
  },
  {
    label: "UAE",
    value: "100"
  },
  {
    label: "US",
    value: "30"
  },
  {
    label: "China",
    value: "30"
  }
];

const chartConfig2 = {
    //Specify the chart type
    type: "pie2d",
    //Set the container object
    renderAt: "chart-container",
    //Specify the width of the chart
    width: "100%",
    //Specify the height of the chart
    height: "400",
    //Set the type of data
    dataFormat: "json",
    dataSource: {
      chart: {
        //Set the chart caption
        caption: "Countries With Most Oil Reserves [2017-18]",
        //Set the chart subcaption
        subCaption: "In MMbbl = One Million barrels",
        //Set the x-axis name
        xAxisName: "Country",
        //Set the y-axis name
        yAxisName: "Reserves (MMbbl)",
        numberSuffix: "K",
        //Set the theme for your chart
        theme: "fusion"
      },
      // Chart Data from Step 2
      data: chartData
    }
  };
  FusionCharts.ready(function() {
    new FusionCharts({
      ...chartConfig2,
      renderAt: "chart2",
    }).render();
  });
