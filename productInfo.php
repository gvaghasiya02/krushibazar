<?php
    session_start();
    require_once('./classes/user.php');
    if(isset($_SESSION['user']))
    {
        $user=unserialize($_SESSION['user']);
        if($user->category!='user')
            header('location:logout.php');
    }
    else header('location:login.php');

    require_once('./classes/product.php');
    require_once 'config.php';
    $star5=$star4=$star3=$star2=$star1=$userCount=0;
    if(isset($_POST["productInfo"]))
    {   
        $pid=$_POST['pid'];
        $sql="SELECT `pname`,`category`,`pinfo`,`price`,`image`,`userid`,`pid`,`qty` FROM product where pid='$pid'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        $product=new Product($row['pid'],$row['pname'],$row['category'],$row['pinfo'],$row['price'],$row['image'],$row['userid'],$row['qty']);
        $sql="SELECT * from rating natural join user WHERE pid='$pid' and user.id=rating.userid";
        $review=$conn->query($sql);
        $userCount=$review->num_rows;
        $comments=array();
        while($row=$review->fetch_assoc())
        {
            if($row['star']==5)
            {
                $star5++;
            }
            elseif($row['star']==4)
            {
                $star4++;
            }
            elseif($row['star']==3)
            {
                $star2++;
            }
            elseif($row['star']==2)
            {
                $star2++;
            }
            elseif($row['star']==1)
            {
                $star1++;
            }
            array_push($comments,$row);
        }
        $totalRating=$star5*5+$star4*4+$star3*3+$star2*2+$star1;
        $avgRating=$totalRating/$userCount;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        .fa {
            font-size: 25px;
            color:grey;
        }
        .checked {
            color: orange;
        }
    </style>
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
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $user->email;?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a  class="nav-link" href="cart.php">My Cart</a></li>
            <li class="nav-item"><a  class="nav-link" href="listorders.php">Your Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container shadow-sm my-4 content-center">
        <div class="row py-3">
            <div class="col-md-4">
                <img class='card-img-top' height="400px" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product->image); ?>" alt='Card image cap'>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Name : <?php echo $product->pname;?></h4>
                    </div>
                    <div class="col-md-12">
                        <h5>Category : <?php echo $product->category;?></h5>
                    </div>
                    <div class="col-md-12">
                        <h4>About : <?php echo $product->pinfo;?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6"><h3>User Rating</h3>
                <i class="fa fa-star <?php if($avgRating>=1) echo 'checked'; ?>"></i>
                <i class="fa fa-star <?php if($avgRating>=2) echo 'checked'; ?>"></i>
                <i class="fa fa-star <?php if($avgRating>=3) echo 'checked'; ?>"></i>
                <i class="fa fa-star <?php if($avgRating>=4) echo 'checked'; ?>"></i>
                <i class="fa fa-star <?php if($avgRating==5) echo 'checked'; ?>"></i>
            </div>
            <div class="col-md-6">
                <span>5 Star : <?php echo $star5; ?> Users</span><br>
                <span>4 Star : <?php echo $star4; ?> Users</span><br>
                <span>3 Star : <?php echo $star3; ?> Users</span><br>
                <span>2 Star : <?php echo $star2; ?> Users</span><br>
                <span>1 Star : <?php echo $star1; ?> Users</span><br>
            </div>
            <div class="col-md-6">
                <p><?php echo $avgRating; ?> average based on <?php echo $userCount; ?> reviews.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">Comments</div>
            <?php 
                for($i=0;$i<10 && $i<count($comments);$i++)
                    echo "<div class='col-md-12'>".$comments[$i]['comment']." by ".$comments[$i]['email']."</div>";
                    ?>
        </div>
    </div>
</body>
</html>