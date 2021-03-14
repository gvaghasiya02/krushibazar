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

    require_once 'config.php';
    $userid=$user->userid; 
    $sql="SELECT `orderid`,`daddress`,`dcity`,`dstate`,`odate` FROM `listorder` WHERE `userid`='$userid' ORDER BY `odate` DESC";
    $lorders=$conn->query($sql);
    $ords=array();
    if($lorders)
    {
        while($row=$lorders->fetch_assoc())
        {
            array_push($ords,$row);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yourorders</title>
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
    <div class="container mt-4 col-md-8">
        <?php
            if($lorders->num_rows==0)
            {
                echo "<h4 class='text-center'>You haven't Ordered Anything</h4>";
            }
            else
            { ?>
            <h4>Your Orders</h4>
                <table class="table  table-striped" cellpadding=5px align=center>
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sr. No.</th>
                            <th class="text-center" scope="col">OrderId</th>
                            <th class="text-center" scope="col">Address</th>
                            <th class="text-center" scope="col">Date</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $srno=1;
                        foreach($ords as $key=>$value)
                        {
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++;
                            $_SESSION['oid']=$value['orderid'];
                            ?>
                                <th class="text-center"><?php echo $value['orderid']?></th>
                                <th class="text-center"><?php echo $value['daddress'];?><br><?php echo $value['dcity'].",".$value['dstate'];?></th>
                                <th class="text-center"><?php echo $value['odate'];?></th>
                                <form action="bill.php" method="post">
                                    <th width=5 class="text-center">
                                    <input type="hidden" name="orid" value=<?php echo $value['orderid'];?> >
                                        <button name="viewbill" type="submit" class="btn btn-success">View Order</button>
                                    </th>
                                </form>
                               
                        </tr>
                        <?php } } ?>
                        </tbody>
                </table>
                </div>
                </body>
</html>