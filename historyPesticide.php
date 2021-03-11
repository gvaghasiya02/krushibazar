<?php
    session_start();
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
    <title>Home</title>
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
    <table>
    <?php 
                        $srno=1;
                        foreach($listpest as $key=>$value)
                        {
                            ?>
                            <tr>
                            <th class="text-center"><?php echo $srno ?></th>
                            <?php $srno++?>
                                <th class="text-center"><img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($value['image']);?>" height=150 /></th>
                                <th class="text-center"><?php echo $value['pname']?></th>
                                <th class="text-center"><?php echo $value['qty']?></th>
                                <th class="text-center"><?php echo $value['price']?></th>
                                <th><form action="" method="post" id="form1">
                                    <input type="hidden" name="pid" value=<?php echo $value['pid']; ?>>                                  
                                    <button type="submit" name="removeFromCart" class="btn btn-danger" alt="Remove"><i class="fa fa-close"></i></button>
                                </form>
                                </th>
                        </tr><?php } ?></table>
</body>
</html>
