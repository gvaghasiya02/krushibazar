<?php
session_start();
require_once 'config.php';
$userid=$_SESSION['id'];
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
<title>Selling</title>
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
    <div class="container mt-4">
        <?php
            if($uproduct->num_rows==0)
            {
                echo "<h4 class='text-center'>You haven't added any products</h4>";
            }
            else
            { ?>
            <h4>Your Products</h4>
                <table class="table  table-striped" cellpadding=5px align=center>
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sr. No.</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Price</th>
                            <th class="text-center" scope="col" colspan=3>Quantity</th>
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
                                <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']);?>" height=150 /></th>
                                <th class="text-center"><?php echo $value['pname']?></th>
                                <th class="text-center"><?php echo $value['category']?></th>
                                <th class="text-center"><?php echo $value['price']?></th>
                                <form action="" method="post">
                                    <th width=5 class="text-center">
                                        <button name="increment" type="submit" class="btn btn-success"><i class="fa fa-plus"></i></button>
                                    </th>
                                    <th class="text-center">
                                        <input type="hidden" name="pid" value=<?php echo $value['pid']; ?>>
                                        <input name="qty" type="hidden" value=<?php echo $value['qty']?>></input>
                                        <h4><?php echo $value['qty']?></h4>
                                    </th>
                                    <th  width=5 class="text-center">
                                        <button name="decrement" type="submit" <?php if($value['qty']=='1') echo "disabled"; ?> class="btn btn-success"><i class="fa fa-minus"></i></button>
                                    </th>
                                </form>
                        </tr>
                        <?php }} ?>
                        </tbody>
                </table>
</body>
</html>