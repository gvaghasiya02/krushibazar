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
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <?php
            if($cartVal->num_rows==0)
            {
                echo "<h4 class='text-center'>Cart is Empty:(</h4>";
            }
            else
            { ?>
                <table className="table" cellpadding=5px align=center border=1px>
                    <thead className="thead-light">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Info</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Actions</th>
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
                            $cart_total+=($item['price']*$value['qty']);
                            $cart_qty+=$value['qty'];
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                            <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($item['image']);?>" height=150 /> </th>
                            <th class="text-center"><?php echo $item['pname']?></th>
                            <th class="text-center"><?php echo $item['category']?></th>
                            <th class="text-center"><?php echo $item['pinfo']?></th>
                            <th class="text-center"><?php echo $item['price']?></th>
                            <th class="text-center"><form action="" method="post">
                                <input type="hidden" name="pid" value=<?php echo $item['pid']; ?>>
                                <input name="qty" type="hidden" value=<?php echo $value['qty']?>></input>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <button name="increment" type="submit" <?php if($value['qty']==$item['qty']) echo "disabled"; ?> class="btn btn-success btn-block">+</button>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4><?php echo $value['qty']?></h4>
                                    </div>
                                    <div class="col-lg-4">
                                        <button name="decrement" type="submit" <?php if($value['qty']==1) echo "disabled"; ?>class="btn btn-success btn-block">-</button>
                                    </div>
                                </div>
                            </form></th>
                            <th class="text-center"><?php echo $item['price']*$value['qty']; ?></th>
                            <th><form action="" method="post">
                                <input type="hidden" name="pid" value=<?php echo $item['pid']; ?>>
                                <button name="removeFromCart" class="btn btn-success btn-block">Remove from Cart</button>
                            </form></th>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center">Total Quantity : <?php echo $cart_qty; ?></th>
                            <th class="text-center">Cart Sub-Total : <?php echo $cart_total; ?></th>
                            <th></th>
                        </tr>
                        </tbody>
                </table>
            <?php } ?>

            <div class="d-flex flex-row-reverse bd-highlight my-4">
            <a class="btn btn-success ml-12" href="checkout.php">Checkout</a>
            </div>
    </div>
</body>
</html>