<?php
    session_start();
    require_once 'config.php';
    $userid=$_SESSION['id']; 
    if(isset($_POST['increment']))
    {
        $product_id=$_POST['pid'];
        $quantity=(int)$_POST['qty']+1;
        $sql="UPDATE `cart` SET `qty` = $quantity WHERE `userid` = $userid and `productid`=$product_id";
        $increment=$conn->query($sql);
    }
    if(isset($_POST['decrement']))
    {
        $product_id=$_POST['pid'];
        $quantity=(int)$_POST['qty']-1;
        $sql="UPDATE `cart` SET `qty` = $quantity WHERE `userid` = $userid and `productid`=$product_id";
        $increment=$conn->query($sql);
    }
    if(isset($_POST['removeFromCart']))
    {
        $product_id=$_POST['pid'];
        $sql="DELETE FROM `cart` WHERE `userid` = $userid and `productid`=$product_id";
        $remove=$conn->query($sql);
    }
    if(isset($_POST['addToCart']))
    {
        $product_id=$_POST['pid'];
        $quantity=(int)$_POST['qty'];
        $sql="UPDATE `cart` SET `qty` = $quantity WHERE `userid` = $userid and `productid`=$product_id";
        $increment=$conn->query($sql);
    }
    $sql="SELECT `productid`,`qty` FROM `cart` WHERE `userid`='$userid'";
    $cartVal=$conn->query($sql);
    $cart=array();
    if($cartVal)
    {
        while($row=$cartVal->fetch_assoc())
        {
            array_push($cart,$row);
        }
    }
    $savedForLater=0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
                <li class="nav-item active"><a  class="nav-link" href="cart.php">My Cart</a></li>
                <li class="nav-item"><a  class="nav-link" href="listorders.php">Your Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4 col-md-8">
        <?php
            if($cartVal->num_rows==0)
            {
                echo "<h4 class='text-center'>Cart is Empty</h4>";
            }
            else
            { ?>
            <h4>Your Cart</h4>
                <table class="table  table-striped " cellpadding=5px align=center>
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sr. No.</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Category</th>
                            <th class="text-center" scope="col">Price</th>
                            <th class="text-center" scope="col" colspan=3>Quantity</th>
                            <th class="text-center" scope="col">Total</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $srno=1;
                        $cart_total=0;
                        $cart_qty=0;
                        $sql="SELECT `pid`,`pname`,`category`,`pinfo`,`price`,`image`,`qty` FROM `product` WHERE `pid`=?";
                        $stmt=$conn->prepare($sql);
                        $stmt->bind_param('s',$param_pid);
                        foreach($cart as $key=>$value)
                        {
                            $param_pid=$value['productid'];
                            $stmt->execute();
                            $result=$stmt->get_result();
                            $item=$result->fetch_array(MYSQLI_ASSOC);
                            if($item['qty']<$value['qty'])
                            {
                                $savedForLater++;
                                continue;
                            }
                            $cart_total+=($item['price']*$value['qty']);
                            $cart_qty+=$value['qty'];
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                                <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($item['image']);?>" height=150 /></th>
                                <th class="text-center"><?php echo $item['pname']?></th>
                                <th class="text-center"><?php echo $item['category']?></th>
                                <th class="text-center"><?php echo $item['price']?></th>
                                <form action="" method="post">
                                    <th width=5 class="text-center">
                                        <button name="increment" type="submit" <?php if($value['qty']==$item['qty']) echo "disabled"; ?> class="btn btn-success"><i class="fa fa-plus"></i></button>
                                    </th>
                                    <th class="text-center">
                                        <input type="hidden" name="pid" value=<?php echo $item['pid']; ?>>
                                        <input name="qty" type="hidden" value=<?php echo $value['qty']?>></input>
                                        <h4><?php echo $value['qty']?></h4>
                                    </th>
                                    <th  width=5 class="text-center">
                                        <button name="decrement" type="submit" <?php if($value['qty']=='1') echo "disabled"; ?> class="btn btn-success"><i class="fa fa-minus"></i></button>
                                    </th>
                                </form>
                                <th class="text-center"><?php echo $item['price']*$value['qty']; ?></th>
                                <th><form action="" method="post" id="form1">
                                    <input type="hidden" name="pid" value=<?php echo $item['pid']; ?>>                                  
                                    <button type="submit" name="removeFromCart" class="btn btn-danger" alt="Remove"><i class="fa fa-close"></i></button>
                                </form>
                                </th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th colspan=5></th>
                            <th colspan=3 class="text-center">Total Quantity:<?php echo $cart_qty; ?></th>
                            <th class="text-center">Cart Total : <?php echo $cart_total; ?></th>
                            <th></th>
                        </tr>
                        </tbody>
                </table>
                <div class="d-flex flex-row-reverse bd-highlight my-4">
                    <!-- Button trigger modal -->
                    <button type="button" <?php if($savedForLater!=0) echo"disabled"; ?> class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Checkout
                    </button>
                </div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Please Confirm</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to Checkout??
                        </div>
                        <div class="modal-footer">
                            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                        </div>
                        </div>
                    </div>
                    </div>
            <?php } ?>
    </div>
    <div class="container mt-4">
        <?php
            if($savedForLater!=0)
            { ?>
                <h4>Saved For Later</h4>
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
                        $cart_total=0;
                        $cart_qty=0;
                        $sql="SELECT `pid`,`pname`,`category`,`pinfo`,`price`,`image`,`qty` FROM `product` WHERE `pid`=?";
                        $stmt=$conn->prepare($sql);
                        $stmt->bind_param('s',$param_pid);
                        foreach($cart as $key=>$value)
                        {
                            $param_pid=$value['productid'];
                            $stmt->execute();
                            $result=$stmt->get_result();
                            $item=$result->fetch_array(MYSQLI_ASSOC);
                            if($item['qty']>=$value['qty'])continue;
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                                <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($item['image']);?>" height=150 /></th>
                                <th class="text-center"><?php echo $item['pname']?></th>
                                <th class="text-center"><?php echo $item['category']?></th>
                                <th class="text-center"><?php echo $item['price']?></th>
                                <th class="text-center"><h4><?php echo $value['qty']; ?> Not Available <?php 
                                if($item['qty']!=0){
                                    echo "<br>only ".$item['qty']." Available";
                                    echo "<form action='' method='post' id='form1'>
                                    <input type='hidden' name='pid' value=".$item['pid'].">
                                    <input type='hidden' name='qty' value=".$item['qty'].">                                  
                                    <button type='submit' name='addToCart' class='btn btn-success' alt='Remove'><i class='fa fa-plus'></i></button>";
                                } 
                                ?></h4></th>
                                <th><form action="" method="post" id="form1">
                                    <input type="hidden" name="pid" value=<?php echo $item['pid']; ?>>                                  
                                    <button type="submit" name="removeFromCart" class="btn btn-danger" alt="Remove"><i class="fa fa-close"></i></button>
                                </form>
                                </th>
                        </tr>
                        <?php } ?>
                        </tbody>
                </table>
            <?php } ?>
    </div>
</body>
</html>