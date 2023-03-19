// Chart Data
const chartData = [{
    "label": "Venezuela",
    "value": "290"
}, {
    "label": "Saudi",
    "value": "260"
}, {
    "label": "Canada",
    "value": "180"
}, {
    "label": "Iran",
    "value": "140"
}, {
    "label": "Russia",
    "value": "115"
}, {
    "label": "UAE",
    "value": "100"
}, {
    "label": "US",
    "value": "30"
}, {
    "label": "China",
    "value": "30"
}];

// Chart Configurations
const chartConfig = {
    type: 'bar2d',
    renderAt: 'chart',
    width: '100%',
    height: '100%',
    dataFormat: 'json',
    dataSource: {
        "chart": {
            "caption": "Countries With Most Oil Reserves [2017-18]",
            "subCaption": "In MMbbl = One Million barrels",
            "xAxisName": "Country",
            "yAxisName": "Reserves (MMbbl)",
            "numberSuffix": "K",
            "theme": "fusion",
            "exportEnabled": "1",
        },
        "data": chartData
    }
};

const chartConfig2 = {
    type: 'bar2d',
    renderAt: 'chart2',
    width: '100%',
    height: '100%',
    dataFormat: 'json',
    dataSource: {
        "chart": {
            "caption": "Countries With Most Oil Reserves [2017-18]",
            "subCaption": "In MMbbl = One Million barrels",
            "xAxisName": "Country",
            "yAxisName": "Reserves (MMbbl)",
            "numberSuffix": "K",
            "theme": "fusion",
            "exportEnabled": "1",
        },
        "data": chartData
    }
};

var fusioncharts = new FusionCharts(chartConfig);
fusioncharts.render();

var fusioncharts2 = new FusionCharts(chartConfig2);
fusioncharts2.render();


var chartTypeSelect = document.getElementById("chartType");
chartTypeSelect.addEventListener('change', function () {
    var selectedChartType = chartTypeSelect.value;
    console.log(chartTypeSelect);
    if (selectedChartType == "pie2d") {
        fusioncharts.chartType('pie2d');
    console.log('HELLO');

    }
    else if (selectedChartType == "bar2d") {
        fusioncharts.chartType('bar2d');
    console.log('HELLO');

    }
});










  // Get the current page URL
const currentUrl = window.location.href;

// Get the link elements
const page1Link = document.getElementById('my_dashboard-link');
const page2Link = document.getElementById('dashboard-link');

// Check which link matches the current page URL
if (currentUrl.includes('my_dashboard.php')) {
page1Link.classList.add('active-link');
} else if (currentUrl.includes('dashboard.php')) {
page2Link.classList.add('active-link');
}




var charts = [];






(function () {
    document.getElementById('addChart').addEventListener('click', function() {
        console.log("HELLO");
        createChart();
    });
})()




