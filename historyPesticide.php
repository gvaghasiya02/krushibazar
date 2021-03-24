<?php
    session_start();
    require_once('./classes/user.php');
    if(isset($_SESSION['user']))
    {
        $user=unserialize($_SESSION['user']);
        if($user->category!='admin')
            header('location:logout-admin.php');
    }
    else header('location:login-admin.php');

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <img src="https://cdn.discordapp.com/attachments/809280919991091212/824313211875622963/1d4f1ba8-89b8-476e-9de4-e15e896c81c9.png" width="50" alt="">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item "><a class="nav-link" href="home-admin.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="salePesticide.php">Add Pesticides</a></li>
                <li class="nav-item active"><a class="nav-link" href="historyPesticide.php">Pesticides History</a></li>
                <li class="nav-item"><a class="nav-link">logged in as:<?php echo $user->email;?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="logout-admin.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container mt-4">
    <?php 
        if($result->num_rows==0)
        {?>
        <h1 align="center">No History Available</h1>
        <?php
        }
        else{
    ?>
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
        <?php } ?>
    </div>
</body>
</html>
