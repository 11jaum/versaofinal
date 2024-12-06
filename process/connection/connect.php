<?php
    $con = mysqli_connect("localhost", "root", "1234", "papocabecachat");
    mysqli_query($con, "SET time_zone='+00:00'");

    date_default_timezone_set("UTC");

    if(mysqli_connect_errno()) {
        echo "Falha ao se conectar".mysqli_connect_error();
        exit();
    }
?>