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
        include_once("includes/charts.php");
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

             while($graphInformation = $rawGraphInformation->fetch_assoc()){
                 $graphType = $graphInformation['GraphType'];
                 $graphName = $graphInformation['GraphName'];
                 $graphText = $graphInformation['GraphText'];
                 $xAxisName = $graphInformation['XAxisName'];
                 $yAxisName = $graphInformation['YAxisName'];

                 $rawGraphData = $conn->query("SELECT DataValue, DataText, DataType FROM data WHERE GraphID = " . $graphID);
                
                 $chartData = array(
                     "chart:" => array(
                         "caption: " => $graphName,
                         "subCaption: " => $graphText,
                         "xAxisName: " => $xAxisName,
                         "yAxisName: " => $yAxisName,
                         "theme:" => "fusion"
                     ),
                     "data" => array()
                 );

                 while($dataRows = $rawGraphData->fetch_assoc()){
                     $dataValue = $dataRows['DataValue'];
                     $dataText = $dataRows['DataText'];
                     $dataType = $dataRows['DataType'];

                     $chartData["data"][] = array(
                         "label: " => $dataText,
                         "value: " => $dataValue
                     );
                 }

                 $fcChart = new FusionCharts($graphType, $graphName, '600', '400', 'graph-' . $graphID, 'json', json_encode($chartData));

                  echo '<div class="chart-container">';
                  echo '<h2>' . $graphName . '</h2>';
                  echo '<div id="graph-' . $graphID . '">' . $fcChart->render() . '</div>';
                  echo '</div>';
                      }
             }
    ?>

    <?php
    CloseCon($conn);
    ?>
</body>

</html>
