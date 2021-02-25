<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Home</title>
</head>
<body>
<div class="container">

  <h1 align="center">Welcome to Krushibazar</h1>
</div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav mr-auto">
      <li class="active"><a href="home.php">Home</a></li>
      <li><a href="sale.php">Selling Crops</a></li>
      <li><a href="buying.php">Buying Crops</a></li>
      <li><a href="pesticides.php">Buying Pesticides</a></li>
      <li><a href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
      </ul>
      <ul class="nav navbar-nav">
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
</body>
</html>
