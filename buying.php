<?php
    session_start();
    require_once 'config.php';
    $chid=$_SESSION['id'];
    $sql="SELECT `cname`,`category`,`cinfo`,`price`,`image`,`userid`,`id` FROM product where userid!=$chid";
    $result=$conn->query($sql);
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
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="pesticides.php">Buying Pesticides</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class='container mt-4' >
            <div class="row">
            <?php
            #var_dump($result);
                if($result->num_rows==0)
                 echo "<h4>No Crops to sell</h4>";
                else
                {
                    while($row=$result->fetch_assoc())
                    {   #echo $row['cname'];?>
                    <div class='col-12 col-md-6 col-lg-3'>
                        <div class='card'>
                            <img class='card-img-top' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" alt='Card image cap'>
                            <div class='card-body'>
                                <h4 class='card-title'><a href='product.html' title='View Product'><?php $row['cname'];?></a></h4>
                                <p class='card-text'><?php echo $row['cinfo'];?></p>
                                <div class='row'>
                                    <div class='col'>
                                        <p class='btn btn-danger btn-block'><?php echo $row['price'];?></p>
                                    </div>
                                    <div class='col'>
                                        <a href='#' class='btn btn-success btn-block'>Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><?php
                    }
                }
            ?>
            </div>
    </div>
                </body>
                </html>