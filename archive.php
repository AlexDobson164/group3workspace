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
        $query = "SELECT GraphID FROM archivedgraphs WHERE ClientID = " . $userInfo['ClientID'];
        $graphIDs = $conn->query($query);
        //this is to hide a warning on line 75, there is no error it is just PHP complaining. Comment it out if you are working on this page
        ini_set('display_errors', 0);
    ?>

    <?php
    while($rawGraphID = $graphIDs->fetch_assoc()){
        $graphID = $rawGraphID['GraphID'];
        $getGraphTypes = "SELECT GraphID, GraphType, GraphText, config from graphs WHERE GraphID = ". $graphID;
        $GraphTypes = $conn->query($getGraphTypes);
        $currentGraphPosition = null;

        $row = mysqli_fetch_assoc($GraphTypes);
        echo "<div class=chart-container>";
        echo "<div id=\"chart-$graphID\">Chart Should Load Here!</div>";
        echo "<form name=". $graphID ." method=\"post\">";
        echo "<input type=\"hidden\" name=\"chartID\" value=". $graphID .">";
        $data = $conn->query("SELECT position FROM graphorderuser WHERE userID = ". $userInfo['UserID'] ." AND graphID = ". $graphID);
        if ($data->num_rows < 0)
        {
            echo "<input type=\"submit\"  name=\"chartAddPersonal\" class=\"button\" value=\"Add To My Dashboard\"/>";
        }
        
        if ($userInfo['permission'] == 'Admin') 
        {
            $data = $conn->query("SELECT position FROM graphorderclient WHERE clientID = ". $userInfo['ClientID'] ." AND graphID = ". $graphID);
            if ($data->num_rows < 0)
            {
                echo "<input type=\"submit\"  name=\"chartAddCompany\" class=\"button\" value=\"Add To Company Dashboard\"/>";
            }
            echo "<input type=\"submit\"  name=\"chartDelete\" class=\"button\" value=\"Delete\"/>";
        }
        echo "</form>";
        echo "</div>";

        $width = 500;
        $height= 400;
        // Retrieve the FusionCharts configuration from the database
        $config = json_decode($row['config'], true); // $row is the database row for the chart

        // Render the chart using the retrieved configuration
        $newChart = new FusionCharts($row['GraphType'], $row['GraphID'].$graphID, $width, $height, "chart-".$graphID, "json", json_encode($config));
        $newChart->render();
}
    ?>

    <?php
        if (isset($_POST))
        { 
            $id = $_POST['chartID'];
            $refresh = false;
            $query;
            if (isset($_POST['chartAddPersonal']))
            {
                $highestPosition = ($conn->query("SELECT position FROM graphorderuser WHERE userID = ". $userInfo['UserID'] ." ORDER BY Position DESC"))->fetch_assoc()['position'];
                $position = $highestPosition + 1;
                $query = "INSERT INTO graphorderuser (userID, graphID, position) VALUES (". $userInfo['UserID'] .", ". $id .", ". $position .")";
                $refresh = true;
            }

            elseif (isset($_POST['chartAddCompany']))
            {
                $highestPosition = ($conn->query("SELECT position FROM graphorderclient WHERE clientID = ". $userInfo['ClientID'] ." ORDER BY Position DESC"))->fetch_assoc()['position'];
                $position = $highestPosition + 1;
                $query = "INSERT INTO graphorderclient (clientID, graphID, position) VALUES (". $userInfo['ClientID'] .", ". $id .", ". $position .")";
                $refresh = true;
            }

            elseif (isset($_POST['chartDelete']))
            {
                $conn->query("DELETE FROM graphorderuser WHERE GraphID = " .$graphID);
                $conn->query("DELETE FROM graphorderclient WHERE GraphID = " .$graphID);
                $conn->query("DELETE FROM data WHERE GraphID = " .$graphID);
                $conn->query("DELETE FROM archivedgraphs WHERE GraphID = " .$graphID);
                $query = "DELETE FROM graphs WHERE ClientID = ". $userInfo['ClientID'] ." AND GraphID = " .$graphID;
                $refresh = true;
            }
            $conn->query($query);
            if ($refresh == true)
            {
                header("Location: archive.php");
            }
        }
    ?>

    <?php
        CloseCon($conn);
    ?>
</body>

</html>