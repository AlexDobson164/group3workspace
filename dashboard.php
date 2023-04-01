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
         while($graphOrderRows = $graphOrder->fetch_assoc()){
            $rawGraphID = $conn->query("SELECT GraphID FROM graphorderclient WHERE Position = " . $graphOrderRows['Position'] . " AND ClientID = " . $userInfo['ClientID']);
            $graphID = $rawGraphID->fetch_assoc()['GraphID'];
            $rawGraphInformation = $conn->query("SELECT GraphName, GraphType, GraphText, XAxisName, YAxisName FROM graphs WHERE GraphID = " . $graphID);
            $rawGraphData = $conn->query("SELECT DataValue, DataText, DataType FROM data WHERE GraphID = " . $graphID);

        
            //loops through sql results
            //I'm aware three nested while loops is fucking retarded but here we are.

            while ($row = mysqli_fetch_assoc($rawGraphInformation)) {
                //determines which graph type/ config it needs to load.
                //Loops until all rows returned in SQL are rendered. (I think)
                
                $graphName = $row['GraphName'];
                $graphType = $row['GraphType']; //keeps the information stored for each loop,
                $graphText = $row['GraphText']; //iterating causes the data to be lost and inaccessible.

                switch($row['GraphType']){

                    // < --- Angular Gauge Chart --- >
                        case 'angulargauge':
                            $angularQuery = "SELECT DataType, DataValue FROM data WHERE GraphID = ". $graphID;
                            $angularResult = mysqli_query($conn, $angularQuery);
                    
                            // Build the associative array
                            $angularData = array();
                            while ($row = mysqli_fetch_assoc($angularResult)) {
                                $dataType = $row['DataType'];
                                $dataValue = $row['DataValue'];
                                if (!isset($angularData[$dataType])) {
                                    $angularData[$dataType] = array();
                                }
                                $angularData[$dataType][] = $dataValue;
                                $currentGraphPosition = $graphOrderRows['Position'];
                            }
                    
                            //access specific data here for the individual chart config,
                            //i.e "minValue": $data['RedMinValue'], etc
                            
                            $config = new StdClass();
                            $config->chart = new StdClass();
                            $config->chart->caption = $graphName;
                            $config->chart->subcaption = $graphText;
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
                                )
                            );
                           
                            //Use this variable to render the chart.
                    
                            $angularGaugeData = json_encode($config);

                            
                            echo "<div class=chart-container>";
                            echo "<div id=\"chart-1\">Chart Should Load Here!</div>";
                            echo "<button id=\"chartDelete\">Delete</button>";
                            echo "</div>";

                            $angularChart = new FusionCharts("angulargauge", "chart","500", "400", "chart-1", "json", $angularGaugeData);
                            // Render the chart
                            $angularChart->render();
                }
            
        }

    }         
    ?>
    <?php
    CloseCon($conn);
    ?>
</body>
</html>
