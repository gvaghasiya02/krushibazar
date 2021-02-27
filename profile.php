<?php
    session_start();
    require_once 'config.php';
    $userid=$_SESSION['id'];
    $email=$password=$firstname=$lastname=$address=$state=$city=$phonenumber=$gender=$dob="";
    $sql="SELECT email,password,firstname,lastname,address,state,city,phonenumber,gender,dob FROM user where id='$userid'";
    $result=$conn->query($sql);
    if($result->num_rows==1)
    {
        $row = $result->fetch_assoc();
        $email=$row['email'];
        $password=$row['password'];
        $firstname=$row['firstname'];
        $lastname=$row['lastname'];
        $address=$row['address'];
        $state=$row['state'];
        $city=$row['city'];
        $phonenumber=$row['phonenumber'];
        $gender=$row['gender'];
        $dob=$row['dob'];
    }
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container my-5">
        <div class="main-body">
            <!-- /Breadcrumb -->
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
                                <div class="mt-3">
                                    <h4><?php echo $email;?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                            <div class="col-sm-9 text-secondary">
                            <?php echo $firstname." ".$lastname;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">PhoneNumber</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                            <?php echo $phonenumber;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"> Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $address;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"> City</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $city;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"> State</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $state;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"> Gender</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $gender;?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0"> Date Of Birth</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $dob;?>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>