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
    else
    {
        #echo $_POST['oqty'];
        $newqty=$_POST['oqty']+$_POST['addqty'];
        $prid=$_POST['pid'];
        #echo $prid;
        $sql="UPDATE `product` SET `qty`='$newqty' WHERE `pid`='$prid'";
        $result=$conn->query($sql);
        $success=true;
    }
}
$sql="SELECT * FROM `product` WHERE `userid`=9";
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
    <div class="container mt-4">
        <?php
            if($uproduct->num_rows==0)
            {
                echo "<h4 class='text-center'>You haven't added any products</h4>";
            }
            else
            { ?>
            <h4>Your Products</h4>
                <table class="table  table-striped text-center" cellpadding=5px align=center>
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sr. No.</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Price</th>
                            <th class="text-center" scope="col">Quantity</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $srno=1;
                        foreach($products as $key=>$value)
                        {
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                                <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image']);?>" height=150 /></th>
                                <th class="text-center"><?php echo $value['pname']?></th>
                                <th class="text-center"><?php echo $value['category']?></th>
                                <th class="text-center"><?php echo $value['price']?></th>
                                <form action="" method="post">
                                    <th class="text-center">
                                    <input type="hidden" name="pid" value=<?php echo $value['pid']; ?>>
                                        <input type="hidden" name="oqty" value=<?php echo $value['qty']; ?>>
                                        <h4><?php echo $value['qty']?></h4>
                                    </th>                                   
                                <th><div class="form-group col-md-12 text-center">
                                            <input class="form-control" type="number" name="addqty" id="addqty" placeholder="Quantity need to be added">
                                                </div><button type="submit" name="submit" class="btn btn-primary">Add Quantity</button></th>
                            </form>
                            </tr>
                        <?php }
                    } ?>
                        </tbody>
                </table>
</body>
</html>