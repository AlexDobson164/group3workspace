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
        //This file is a include that makes it so that we can make graphs directky with PHP
        //This is the link to the GitHub Page: https://github.com/fusioncharts/php-wrapper#constructor-parameters
        include("fusioncharts.php");
        $conn = OpenCon();
        session_start();
        //All the data that is related to the user is in this array, access the data by using the names of the database fields
        $userInfo = $_SESSION['userInfo'];
        $query = "SELECT GraphID FROM graphorderclient WHERE ClientID = " . $userInfo['ClientID']. " ORDER BY Position";
        $graphOrder = $conn->query($query);
    ?>

    <?php
    $count = 0; //counts how many times the loop has fired, used to increment the chart-id's programatically.
    while($graphOrderRows = $graphOrder->fetch_assoc()){
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
                echo "<input type=\"hidden\" name=\"chartPos\" value=". $count .">";
                echo "<input type=\"hidden\" name=\"chartID\" value=". $graphID .">";
                echo "<input type=\"submit\"  name=\"chartDelete\" class=\"button\" value=\"Disable\"/>";
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
            $count++;

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
                echo $deleteQuery;
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
                        echo $position;
                    }
                } 
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
