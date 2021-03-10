<?php
$err="<br>";
$success=false;
session_start();
require_once 'config.php';
$userid=$_SESSION['id'];
if(isset($_POST['submit']))
{
    if(empty(trim($_POST['addqty'])) || trim($_POST['addqty'])<1)
    {
        $err.="Enter valid Quantity<br>";
        $success=false;
    }
    if(empty(trim($_POST['cinfo'])))
    {
        $err.="Enter valid information<br>";
        $success=false;
    }
    if($err=="<br>")
    {
        echo $_POST['oqty']." ".$_POST['addqty']." ".$_POST['cinfo']." ".$_POST['pid'];
        $newqty=$_POST['oqty']+$_POST['addqty'];
        echo $newqty;
        $cinfo=$_POST['cinfo'];
        $prid=$_POST['pid'];
        #echo $prid;
        $sql="UPDATE `product` SET `qty`=$newqty,`pinfo`='$cinfo' WHERE `pid`=$prid";
        echo $sql;
        $result=$conn->query($sql);
        if($result)
            $success=true;
    }
}
if(isset($_POST['editProduct']))
{
    $pid=$_POST['pid'];
    $sql="SELECT * FROM `product` WHERE `userid`='$userid' and `pid`='$pid'";
    $productInfo=$conn->query($sql);
    $productDetail=$productInfo->fetch_assoc();
}
$sql="SELECT * FROM `product` WHERE `userid`='$userid'";
$uproduct=$conn->query($sql);
$products=array();
if($uproduct)
{
    while($row=$uproduct->fetch_assoc())
    {
        array_push($products,$row);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
<title>Update Products</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a  class="nav-link" href="cart.php">My Cart</a></li>
            <li class="nav-item"><a  class="nav-link" href="listorders.php">Your Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <?php 
        if($success)
        {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong> Product Addedd Successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'  >&times</span>
            </button>  
            </div>";
        }
        elseif($err!="<br>")
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed to Add the Product</strong>";
            echo $err;
            echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'  >&times;</span>
            </button> 
            </div>";
        }
    ?>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-2">
                <div class="card shadow px-3 py-3">
                    <div class="sidebar-sticky">
                        <ul class="nav flex-column">
                            <?php
                            if($uproduct->num_rows==0)
                            {
                                echo "<h4 class='text-center'>You haven't added any products</h4>";
                            }
                            else
                            { ?>
                            <h4>Your Products</h4>
                            <?php 
                                $srno=1;
                                foreach($products as $key=>$value)
                                {?>
                                    <li class="nav-item my-1">
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-md-6 text-left">
                                                    <?php echo $value['pname']; ?>
                                                </div>
                                                <div class="col-md-6 text-left">
                                                    <input type="hidden" name="pid" value=<?php echo $value['pid']; ?>>
                                                    <button type="submit" name="editProduct"><i class="fa fa-pencil"></i></button></th>
                                                </div>
                                            </div>
                                        </form>
                                    </li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <?php
                    if(isset($_POST['editProduct']))
                    { 
                ?>
                <h4>Edit Product</h4>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="pid" value=<?php echo $productDetail['pid']; ?>>
                    <input type="hidden" name="oqty" value=<?php echo $productDetail['qty']; ?>>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cname">Crop name</label>
                            <input class="form-control" type="text" disabled value='<?php echo $productDetail['pname']; ?>' name="cname" id="cname" placeholder="Enter cname">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cname">Category</label>
                            <input class="form-control" type="text" disabled value='<?php echo $productDetail['category']; ?>' name="ccategory" id="cname" placeholder="Enter cname">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="price">Price</label>
                            <input class="form-control" type="number" disabled value=<?php echo $productDetail['price']; ?> name="price" id="price" placeholder="Enter Price of 500 grams">
                        </div>
                        <div class="form-group col-md-4"> 
                            <label for="qty">Quantity Available</label>
                            <input class="form-control" type="number" disabled value='<?php echo $productDetail['qty']; ?>' name="qty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                        </div>
                        <div class="form-group col-md-4"> 
                            <label for="qty">New Quantity(in 500 grams packets)</label>
                            <input class="form-control" type="number" name="addqty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-12"> 
                            <label for="cinfo">Enter Information</label>
                            <textarea  name="cinfo" id="cinfo" rows="12"><?php echo $productDetail['pinfo']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-3"> 
                            <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>
                </from>
                <script>
                    CKEDITOR.replace( 'cinfo' );
                </script>
            </div>
            <div class="col-md-3">
            <div class='card shadow'>
                <img class='card-img-top' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($productDetail['image']); ?>" alt='Card image cap'>
                <div class='card-body'>
                    <h4 class='card-title'><a href='product.html' title='View Product'><?php echo $productDetail['pname'];?></a></h4>
                    <h5>Quantity:&nbsp<?php echo $productDetail['qty'];?></h5>
                    <p class='card-text'><b><?php echo $productDetail['category'];?></b><br><?php echo $productDetail['pinfo'];?></p>
                    <div class='row'>
                        <div class='col'>
                            <p class='btn btn-danger btn-block'><?php echo $productDetail['price'];?></p>
                        </div>
                        <div class='col'>
                            <form action="" method="post">
                                <input type="hidden" name="pid" value=<?php echo $productDetail['pid']; ?>>
                                <button name="addToCart" class="btn btn-success btn-block">Add To Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <?php }
        ?>
    </div>
</body>
</html>