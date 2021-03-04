<?php
    session_start();
    require_once 'config.php';
    $userid=$_SESSION['id']; 
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
                <table className="table" border=1px>
                    <thead className="thead-light">
                        <tr>
                            <th>Sr. No.</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Info</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $srno=1;
                        $sql="SELECT `pid`,`pname`,`category`,`pinfo`,`price`,`image` FROM `product` WHERE `pid`=?";
                        $stmt=$conn->prepare($sql);
                        $stmt->bind_param('s',$param_pid);
                        foreach($cart as $param_pid)
                        {
                            $stmt->execute();
                            $result=$stmt->get_result();
                            $item=$result->fetch_array(MYSQLI_ASSOC);
                            ?>
                            <tr>
                            <th><?php echo $srno ?></th>
                            <?php $srno++?>
                            <th><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($item['image']);?>" height=300 width=200/> </th>
                            <th><?php echo $item['pname']?></th>
                            <th><?php echo $item['category']?></th>
                            <th><?php echo $item['pinfo']?></th>
                            <th><?php echo $item['price']?></th>
                        </tr>
                            
                       <?php } ?>                </tbody>
                </table>
            <?php } ?>
    </div>
    
</body>
</html>