<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group3Workspace</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <h1>Performance Dashboard: Waterman Group</h1>
    <?php
        include_once("includes/nav.php");
        include("includes\DBConnection.php");
        include("fusioncharts.php");
        $conn = OpenCon();
        session_start();
        //All the data that is related to the user is in this array, access the data by using the names of the database fields
        $userInfo = $_SESSION['userInfo'];
        $query = "SELECT Position FROM graphorderclient WHERE ClientID = " . $userInfo['ClientID'];
        $graphOrder = $conn->query($query);
    ?>

    <?php
        //Consolidated the sql query, everything is now returned pertaining to a graph. 

        $getAllInfo = "SELECT g.GraphID, g.GraphName, g.GraphType, g.GraphText, g.XAxisName, g.YAxisName, d.DataType, d.DataValue, d.DataText
        FROM graphs g
        INNER JOIN graphorderclient go ON go.GraphID = g.GraphID
        INNER JOIN data d ON d.GraphID = g.GraphID
        WHERE go.ClientID = {$userInfo['ClientID']}
        ORDER BY go.Position ASC";

$result = $conn->query($getAllInfo);

$currentGraphPosition = null;

// iterates through returned rows, rendering each graph.
while ($row = mysqli_fetch_assoc($result)) {
    // filters the information depending on the graph type of the row.
    switch($row['GraphType']) {
        case 'angulargauge':
            // Build the associative array: This allows you to access each part of the returned 'Data' values individually by name.
            // i.e $data['RedMinValue'];
            $angularData = array();
            foreach ($result as $row) {
                $dataType = $row['DataType'];
                $dataValue = $row['DataValue'];
                if (!isset($angularData[$dataType])) {
                    $angularData[$dataType] = array();
                }
                $angularData[$dataType][] = $dataValue;
            }

            //constructs the fusionchart JSON config file.
            $config = new StdClass();
            $config->chart = new StdClass();
            $config->chart->caption = $row['GraphName'];
            $config->chart->subcaption = $row['GraphText'];
            $config->chart->plotToolText = $angularData['ShownValue'];
            $config->chart->theme = "fusion";
            $config->chart->chartBottomMargin = "50";
            $config->chart->showValue = "1";

            $config->colorRange = new StdClass();
            $config->colorRange->color = array(
                array(
                    "minValue" => $angularData['RedMinValue'],
                    "maxValue" => $angularData['RedMaxValue'],
                    "code" => "#e44a00"
                ),
                array(
                    "minValue" => $angularData['AmberMinValue'],
                    "maxValue" => $angularData['AmberMaxValue'],
                    "code" => "#f8bd19"
                ),
                array(
                    "minValue" => $angularData['GreenMinValue'],
                    "maxValue" => $angularData['GreenMaxValue'],
                    "code" => "#6baa01"
                )
            );

            $config->dials = new StdClass();
            $config->dials->dial = array(
                array(
                    "value" => $angularData['ShownValue'],
                    "id" => "id"
                )
            );
                           
            //Use this variable to render the chart.
                    
            $angularGaugeData = json_encode($config);

            //Temporarily uses a static chart name, will be adapted once I have other configurations added. 
            //Not dynamic, if you want to implement any other graphs, please call them literally or interpolate the count into the render string.

            echo "<div class=chart-container>";
            echo "<div id=\"chart-1\">Chart Should Load Here!</div>";
            echo "<button id=\"chartDelete\">Delete</button>";
            echo "</div>";

            $angularChart = new FusionCharts("angulargauge", "chart","500", "400", "chart-1", "json", $angularGaugeData);
            // Render the chart
            $angularChart->render();
                
        case 'pie2d':
            
        }
    }
    ?>

 <?php CloseCon($conn); ?>
</body>
</html>
