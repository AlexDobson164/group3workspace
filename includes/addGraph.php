<?php

function saveAngularDataToDB($conn, $clientID, $caption, $subcaption, $input_1) {
  $data = array(
      "chart" => array(
        "caption" => $caption,
        "subcaption" => $subcaption,
        "plotToolText" => $input_1,
        "theme" => "fusion",
        "chartBottomMargin" => "50",
        "showValue" => "1"
      ),
      "colorRange" => array(
        "color" => array(
          array(
            "minValue" => "0",
            "maxValue" => "25",
            "code" => "#e44a00"
          ),
          array(
            "minValue" => "25",
            "maxValue" => "50",
            "code" => "#f8bd19"
          ),
          array(
            "minValue" => "50",
            "maxValue" => "75",
            "code" => "#6baa01"
          )
        )
      ),
      "dials" => array(
        "dial" => array(
          array(
            "value" => $input_1,
            "id" => "id"
          )
        )
      )
    );

    $config = json_encode($data);

    $addAngularQuery = "INSERT INTO graphs(ClientID, GraphName, GraphType, GraphText, config) VALUES($clientID, '$caption', 'angulargauge', '$subcaption', '$config')";

    mysqli_query($conn, $addAngularQuery);
}

function addOtherGraphsToDB($conn, $clientID, $caption, $subcaption, $input_1, $graphType, $xAxisName, $yAxisName) {
  $data = array(
    "chart" => array(
      "caption" => $caption,
      "subcaption" => $subcaption,
      "xAxisName" => $xAxisName,
      "yAxisName" => $yAxisName,
      "showValues" => "1",
      "theme" => "fusion"
    ),
    "data" => array(
      array(
        "label" => "label",
        "value" => $input_1
      ),
      array(
        "label" => "label",
        "value" => $input_1
      )
    )
      );
    
    $config = json_encode($data);
    $addOtherGraphQuery = "INSERT INTO graphs(ClientID, GraphName, GraphType, GraphText, XAxisName, YAxisName, config) VALUES($clientID, '$caption', '$graphType', '$subcaption','$input1','$input2','$config')";

    mysqli_query($conn, $addOtherGraphQuery);
}

?>