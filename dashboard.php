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
        //include("includes/addGraph.php");
        include("includes/DBConnection.php");
        include("includes/addGraph.php");
        //This file is a include that makes it so that we can make graphs directky with PHP
        //This is the link to the GitHub Page: https://github.com/fusioncharts/php-wrapper#constructor-parameters
        include("fusioncharts.php");
        $conn = OpenCon();
        session_start();
        //All the data that is related to the user is in this array, access the data by using the names of the database fields
        $userInfo = $_SESSION['userInfo'];
        $clientID = $userInfo['ClientID'];
        $query = "SELECT GraphID FROM graphorderclient WHERE ClientID = " . $userInfo['ClientID']. " ORDER BY Position";
        $graphOrder = $conn->query($query);
        //this is to hide a warning on line 69 and 70, there is no error it is just PHP complaining. Comment it out if you are working on this page
        ini_set('display_errors', 0);
    ?>

    <div class="menu-container">
        <form method="post" id="my-form" action="">
            <label for="graph-select">Graph Type:</label>
            <select name="graph-select" id="graph-select">
                <option value="">Graphs</option>
                <option value="angulargauge">Angular Graph</option>
                <option value="pie2d">Pie Chart</option>
            </select>
            <label for="data-select">Data Select:</label>
            <select name="data-select" id="data-select">
                <option value="">Data</option>
            </select>
            <label for="caption-input">Caption:</label>
            <input type="text" name="caption-input">
            <label for="subcaption-input">Sub-caption:</label>
            <input type="text" name="subcaption-input">
            <div id="input-fields"></div>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

    <?php
        if(isset($_POST['submit'])) {
            $graphType = $_POST['graph-select'];
            $dataSelect = $_POST['data-select'];
            $caption = $_POST['caption-input'];
            $subcaption = $_POST['subcaption-input'];
            $xAxisName = $_POST['xAxisName'];
            $$yAxisName = $_POST['yAxisName'];
            $input_1 = $_POST['input-1'];
            $input_2 = $_POST['input-2'];
            $input_3 = $_POST['input-3'];

            if($graphType === 'angulargauge') {
                saveAngularDataToDB($conn, $clientID, $caption, $subcaption, $input_1);
            } else {
                addOtherGraphsToDB($conn, $clientID, $caption, $subcaption, $input_1, $graphType, $xAxisName, $yAxisName);
            }
        }
    ?>

    <?php
    $count = 0; //counts how many times the loop has fired, used to increment the chart-id's programatically.
    while($graphOrderRows = $graphOrder->fetch_assoc()){
            $count++;
            $graphID = $graphOrderRows['GraphID'];
            $getGraphTypes = "SELECT GraphID, GraphType, GraphText, config from graphs WHERE GraphID = ". $graphID;
            $GraphTypes = $conn->query($getGraphTypes);
            $currentGraphPosition = null;
        
            $row = mysqli_fetch_assoc($GraphTypes);
            echo "<div class=chart-container>";
            echo "<div id=\"chart-$count\">Chart Should Load Here!</div>";
            $data = $conn->query("SELECT position FROM graphorderclient WHERE clientID = ". $userInfo['ClientID'] ." AND graphID = ". $graphID);
            if ($userInfo['permission'] == "Admin")
            {
                echo "<form name=". $graphID ." method=\"post\">";
                echo "<input type=\"hidden\" name=\"chartPos\" value=". $count ." />";
                echo "<input type=\"hidden\" name=\"chartID\" value=". $graphID ." />";
                //disables the left arrow if the graph is the first one
                if ($count != 1)
                {
                    echo "<input type=\"submit\" name=\"chartMoveUp\" class=\"button\" value=\"<--\"/>";
                }
                echo "<input type=\"submit\"  name=\"chartDelete\" class=\"button\" value=\"Disable\"/>";
                //disbles the arrow on the right if it is the last graph
                $highestPosition = $conn->query("SELECT position FROM graphorderClient WHERE ClientID = ". $userInfo['ClientID'] ." ORDER BY Position DESC")->fetch_assoc()['position'];
                settype($highestPosition, 'int');
                //echo $checkposition;
                //echo $highestPosition;
                if ($count != $highestPosition)
                {
                    echo "<input type=\"submit\" name=\"chartMoveDown\" class=\"button\" value=\"-->\"/>";
                }
                echo "</form>";
            }
            echo "</div>";
        
            $width = 500;
            $height= 400;
            // Retrieve the FusionCharts configuration from the database
            $config = json_decode($row['config'], true); // $row is the database row for the chart
        
            // Render the chart using the retrieved configuration
            $newChart = new FusionCharts($row['GraphType'], $row['GraphID'].$count, $width, $height, "chart-".$count, "json", json_encode($config));
            $newChart->render();
    }
    ?>

<?php
     if (isset($_POST))
     { 
         $id = $_POST['chartID'];
         $position = $_POST['chartPos'];
         $refresh = false;
        if (isset($_POST['chartDelete']))
        {
            $deleteQuery = "DELETE FROM graphorderclient WHERE clientID = ". $userInfo['ClientID'] ." AND graphID = ". $id; 
            $conn->query($deleteQuery);
            $graphIDsQuery = "SELECT GraphID FROM graphorderclient WHERE clientID = ". $userInfo['ClientID'] ." AND Position > ". $position;
            $graphIDs = $conn->query($graphIDsQuery);
            if ($graphIDs->num_rows > 0)
            {
                while($raw = $graphIDs->fetch_assoc())
                {
                    $changedID = $raw['GraphID'];
                    $queryUpdate = "UPDATE graphorderclient SET Position = ". $position ." WHERE clientID = ". $userInfo['ClientID'] ." AND graphID = ". $changedID;
                    $conn->query($queryUpdate);
                    $position++;
                }
            } 
            $refresh = true;
        }
        elseif (isset($_POST['chartMoveUp']))
        {
            $queryUpdate = "UPDATE graphorderclient SET Position = ". $position ." WHERE clientID = ". $userInfo['ClientID'] ." AND Position = ". ($position-1);
            $conn->query($queryUpdate);
            $queryUpdate = "UPDATE graphorderclient SET Position = ". ($position-1) ." WHERE clientID = ". $userInfo['ClientID'] ." AND graphID = ". $id;
            $conn->query($queryUpdate);
            $refresh = true;
        }
        elseif (isset($_POST['chartMoveDown']))
        {
            $queryUpdate = "UPDATE graphorderclient SET Position = ". $position ." WHERE clientID = ". $userInfo['ClientID'] ." AND Position = ". ($position+1);
            $conn->query($queryUpdate);
            $queryUpdate = "UPDATE graphorderclient SET Position = ". ($position+1) ." WHERE clientID = ". $userInfo['ClientID'] ." AND graphID = ". $id;
            $conn->query($queryUpdate);
            $refresh = true;
        }
        if ($refresh == true)
        {
            header("Location: dashboard.php");
        }
    }
    ?>

 <?php CloseCon($conn); ?>
</body>
</html>
<script type="text/javascript" src="./js/addGraph.js"></script>
