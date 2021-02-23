<?php
    /* Configuration of Database Connectivity*/

    define('DB_SERVER','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_DATABASE','krushibazar');

    //try connecting to the Database
    $conn=mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

    //Check Connection
    if(!$conn)
    {
        die('Error:Cannot Connect');
    }
?>