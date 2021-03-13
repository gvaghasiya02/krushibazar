<?php
    session_start();
    if( $_SESSION['loggedin']!="admin" || !isset($_SESSION['email']))
    {
        header('location:login-admin.php');
    }
    require_once 'config.php';
    $user_count=0;
    $sql="select * from product inner join orderdetail where product.pid=orderdetail.pid and category='Pesticide'";
    $result=$conn->query($sql);
    #var_dump($result);
    $listpest=array();
    if($result)
    {
        while($row=$result->fetch_assoc())
        {
            array_push($listpest,$row);
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
    <title>Pesticide History</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item "><a class="nav-link" href="home-admin.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="salePesticide.php">Add Pesticides</a></li>
                <li class="nav-item active"><a class="nav-link" href="historyPesticide.php">Pesticides History</a></li>
                <li class="nav-item"><a class="nav-link">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="logout-admin.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
        <table class="table table-striped text-center">
            <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sr. No.</th>
                            <th class="text-center" scope="col">Image</th>
                            <th class="text-center" scope="col">Name</th>
                            <th class="text-center" scope="col">Quantity ordered</th>
                            <th class="text-center" scope="col">Orderid</th>
                            <th class="text-center" scope="col">Ordered on</th>
                            <th class="text-center" scope="col">Ordered By</th>
                        </tr>
                    </thead>
                    <?php 
                        $srno=1;
                        foreach($listpest as $key=>$value)
                        {  $oid=$value['orderid'];
                            $sqlu="SELECT * FROM listorder natural join user where listorder.orderid=$oid and listorder.userid=user.id";
                            $res=$conn->query($sqlu);
                            $ord=$res->fetch_assoc();
                            
                            ?>
                            
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                                <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image']);?>" height=150 /></th>
                                <th class="text-center"><?php echo $value['pname']?></th>
                                <th class="text-center"><?php echo $value['qty']?></th>
                                <th class="text-center"><?php echo $oid ?></th>
                                <th class="text-center"><?php echo $ord['odate'] ?></th>
                                <th class="text-center"><?php echo $ord['email']?><input type="hidden" name="pid" value=<?php echo $value['pid']; ?>></th>
                        </tr>
                        <?php } ?>
        </table>
    </div>
</body>
</html>
