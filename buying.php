<?php
    session_start();
    require_once 'config.php';
    $userid=$_SESSION['id']; 
    $tt="All";
    $sql="SELECT `pname`,`category`,`pinfo`,`price`,`image`,`userid`,`pid` FROM product where userid!=$userid";
    if(isset($_POST["submit"]))
    {   
        $tt=$_POST['type'];  
        if($tt!="All")
        {
            $sql="SELECT `pname`,`category`,`pinfo`,`price`,`image`,`userid`,`pid` FROM product where userid!=$userid and category='$tt'";
        }
    }
    $result=$conn->query($sql);
    if(isset($_POST['addToCart']))
    {
        $pid=$_POST['pid'];
        $sql="INSERT INTO `cart`(`userid`,`productid`,`qty`) VALUES ('$userid','$pid','1')";
        $insertSuccess=$conn->query($sql);
        //var_dump($insertSuccess);
    }
    $sql="SELECT `productid` FROM `cart` WHERE `userid`='$userid'";
    $cartVal=$conn->query($sql);
    $cart=array();
    if($cartVal)
    {
        while($row=$cartVal->fetch_assoc())
        {
            array_push($cart,$row['productid']);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Buying</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item active"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a  class="nav-link" href="cart.php">My Cart</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    
    <div class='container mt-4' >
    <?php 
        if(isset($_POST['addToCart']) && $insertSuccess)
        {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong> Product added to the Cart.
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }
        elseif(isset($_POST['addToCart']))
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed</strong> Failed to add the Product to Cart.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times</span>
            </button>  
            </div>";
        }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
    <div class="form-row"> 
    <div class="form-group col-md-4">
                    <select class="form-control" name="type" id="type">
                    <option value="All" <?php if($tt=="All")echo "selected"; ?> style="color: black;">All</option>
                        <option value="Fruit" <?php if($tt=="Fruit")echo "selected"; ?> style="color: black;">Fruit</option>
                        <option value="Vegetable" <?php if($tt=="Vegetable")echo "selected"; ?> style="color: black;">Vegetable</option>
                        <option value="Grains" <?php if($tt=="Grains")echo "selected"; ?> style="color: black;">Grains</option>
                        <option value="Pesticide" <?php if($tt=="Pesticide")echo "selected";?> style="color: black;">Pesticide</option>
                    </select>
                </div>
                <div class="form-group col-md-3"> 
                    <button type="submit" name="submit" class="btn btn-primary">Apply</button>
                </div>
                </div>
    </form>
            <div class="row">
            <?php
            // var_dump($result);
                if($result->num_rows==0 )
                {
                    echo "<h4>No Crops to sell</h4>";
                }
                else
                {
                    while($row=$result->fetch_assoc())
                    { ?>
                    <div class='col-12 col-md-6 col-lg-3'>
                        <div class='card'>
                            <img class='card-img-top' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" alt='Card image cap'>
                            <div class='card-body'>
                                <h4 class='card-title'><a href='product.html' title='View Product'><?php echo $row['pname'];?></a></h4>
                                <p class='card-text'><b><?php echo $row['category'];?></b><br><?php echo $row['pinfo'];?></p>
                                <div class='row'>
                                    <div class='col'>
                                        <p class='btn btn-danger btn-block'><?php echo $row['price'];?></p>
                                    </div>

                                    <div class='col'>
                                    <?php
                                        if(in_array($row['pid'],$cart))
                                        {
                                            echo "<a href='cart.php' class='btn btn-success btn-block'>Go To Cart</a>";
                                        }
                                        else
                                        {?>
                                        <form action="" method="post">
                                            <input type="hidden" name="pid" value=<?php echo $row['pid']; ?>>
                                            <button name="addToCart" class="btn btn-success btn-block">Add To Cart</button>
                                        </form>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                    </div><?php
                    }
                }
            ?>
            </div>
    </div>
</body>
</html>