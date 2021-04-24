<?php
    session_start();
    require_once('./classes/user.php');
    if(isset($_SESSION['user']))
    {
        $user=unserialize($_SESSION['user']);
        if($user->category!='admin')
            header('location:logout-admin.php');
    }
    else header('location:login-admin.php');

    require_once 'config.php';
    $user_count=0;
    $sql="SELECT id,email,password FROM user";
    $result=$conn->query($sql);
    $user_count=$result->num_rows;
    $order_count=0;
    $sql="SELECT * FROM orderdetail";
    $result=$conn->query($sql);
    $order_count=$result->num_rows;
    $product_count=0;
    $sql="SELECT * FROM product";
    $result=$conn->query($sql);
    $product_count=$result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Home</title>
</head>
<style>
body {
  background-image:linear-gradient(rgba(0,0,0,0.1),rgba(0,0,0,0.7)),url('./images/bg.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;
}
</style>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <img src="https://cdn.discordapp.com/attachments/809280919991091212/824313211875622963/1d4f1ba8-89b8-476e-9de4-e15e896c81c9.png" width="50" alt="">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="home-admin.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="salePesticide.php">Add Pesticides</a></li>
                <li class="nav-item"><a class="nav-link" href="historyPesticide.php">Pesticides History</a></li>
                <li class="nav-item"><a class="nav-link">logged in as:<?php echo $user->email;?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="logout-admin.php">Logout</a></li>
            </ul>
        </div>
    </nav> 
    <div class="container">
        <h1 class="text-center text">Welcome to Krushibazar</h1>
    </div>
    <div class="container ">
        <div class="row">
        <div class="col-md-4">
            <div class="card bg-transparent shadow-lg">
            <div class="card-body"><h4>Users Registered : <?php echo $user_count?></h4></div></div>
        </div>
        <div class="col-md-4">
            <div class="card bg-transparent shadow-lg">
            <div class="card-body"><h4>Order Received : <?php echo $order_count?></h4></div></div>
        </div>
        <div class="col-md-4">
            <div class="card bg-transparent shadow-lg">
            <div class="card-body"><h4>Products Available : <?php echo $product_count?></h4></div></div>
        </div>    
        </div>
    </div>    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
