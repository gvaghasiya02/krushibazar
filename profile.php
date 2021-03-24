<?php
    $success1=false;
    $err1="<br>";
$success=false;
$err="<br>";
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
    if(isset($_POST['editpass']))
    {
        if(empty(trim($_POST['password'])))
        {
            $err.="Password cannot be empty<br>";
            $success=false;
        }
        elseif(strlen(trim($_POST['password']))<5)
        {
            $err.="Password cannot be less than 5 characters<br>";
            $success=false;
        }
        elseif(trim($_POST['password']) != trim($_POST['confirm_password']))
        {
            $err.="Password should match<br>";
            $success=false;
        }
        else
        {
            $password=password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
            $sql="UPDATE `user` set `password`='$password' where id='$userid'";
            $result=$conn->query($sql);
            #var_dump($result);
            #echo $result;
            $success=true;
        }
        #echo $err;
    }
if(isset($_POST['editprofile']))
{
    if(empty(trim($_POST['firstname'])) || empty(trim($_POST['lastname'])) || empty(trim($_POST['dob'])) || empty(trim($_POST['address'])) || empty(trim($_POST['state'])) || empty(trim($_POST['city'])) || empty(trim($_POST['phonenumber'])) || empty($_POST['gender']))
        {
            $err1.="Enter all details<br>";
            $success1=false;
        }
        elseif(strlen((string)$_POST['phonenumber'])!=10)
        {
            $err1.="Enter correct PhoneNumber<br>";
            $success1=false;
        }
        elseif(round((strtotime(date("D F Y"))-(strtotime($_POST['dob'])))/(31540000))<18)
        {
            $err1.="You Should be 18";
            $success1=false;
        }
        else
        {
            $firstname=$_POST['firstname'];
            $lastname=$_POST['lastname'];
            $dob=$_POST['dob'];
            $address=$_POST['address'];
            $state=$_POST['state'];
            $city=$_POST['city'];
            $phonenumber=$_POST['phonenumber'];
            $gender=$_POST['gender'];
            $sql="UPDATE `user` set `firstname`='$firstname',`lastname`='$lastname',`address`='$address',`state`='$state',`city`='$city',`phonenumber`='$phonenumber',`gender`='$gender',`dob`='$dob' where id='$userid'";
            $result=$conn->query($sql);

            $sql="SELECT id,email,password,firstname,lastname,address,state,city,phonenumber,gender,dob FROM user where id='$userid'";
            $result=$conn->query($sql);
            if($result->num_rows==1)
            {
                $row = $result->fetch_assoc();
                require_once('./classes/user.php');
                $user=new User($row["id"],$row["email"],$row["firstname"],$row["lastname"],$row["address"],$row["state"],$row["city"],$row["phonenumber"],$row["gender"],$row["dob"],'user');
                $_SESSION['user']=serialize($user);
                $_SESSION['loggedin']='user';
                header('location:profile.php');
                
            }
            #echo $sql;
            #var_dump($result);
            #echo $result;
            $success1=true;
        }
        #echo $err1;
    }

    $email=$user->email;
    $firstname=$user->fname;
    $lastname=$user->lname;
    $address=$user->address;
    $state=$user->state;
    $city=$user->city;
    $phonenumber=$user->phno;
    $gender=$user->gender;
    $dob=$user->dob;
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <img src="https://cdn.discordapp.com/attachments/809280919991091212/824313211875622963/1d4f1ba8-89b8-476e-9de4-e15e896c81c9.png" width="50" alt="">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link active" href="profile.php">logged in as:<?php echo $user->email;?></a></li>
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
                            {?>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Success</strong> Your Password is changed.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                                </div>
                            <?php
                            }
                            elseif($err!="<br>")
                            {?>
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Failed </strong><?php echo $err; ?><button type="button" class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times</span>
                                </button>  
                                </div>
                            <?php }
                        ?>
                        <?php 
                            if($success1)
                            {?>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Success</strong> Your Profile updated.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                                </div>
                            <?php
                            }
                            elseif($err1!="<br>")
                            {?>
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Failed </strong><?php echo $err1; ?><button type="button" class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times</span>
                                </button>  
                                </div>
                            <?php }
                        ?>
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
                <div class="container">
  <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editpassword">
  Edit Password
</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editprofile">
  Edit Profile
</button>

<!-- Modal -->
<div class="modal fade" id="editpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>               
      <form method="post" action="">
      <div class="modal-body">
      <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Re-Enter Password">
            </div>
      </div>
      <div class="modal-footer">  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="editpass" class="btn btn-primary">Save changes</button>     
      </div>
      </form>
    </div>
  </div>
</div>
  
</div>
<div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="">
      <div class="modal-body">
      <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname">FirstName</label>
                <input class="form-control" type="text" name="firstname" id="firstname" value="<?php echo $firstname;?>" placeholder="Enter First Name">
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">LastName</label>
                <input class="form-control" type="text" name="lastname" id="lastname" value="<?php echo $lastname;?>" placeholder="Enter Last Name">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dob">Date Of Birth</label>
                <input class="form-control" type="date" name="dob" value="<?php echo $dob;?>" id="dob" placeholder="Enter DOB">
            </div>
            <div class="form-group col-md-6">
                <label for="phonenumber">Phone Number</label>
                <input class="form-control" type="number" name="phonenumber" id="phonenumber" value="<?php echo $phonenumber;?>" placeholder="Enter your Phone Number">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="address">Address</label>
                <input class="form-control" type="textarea" name="address" value="<?php echo $address;?>" id="address" placeholder="Enter your Address">
            </div>
        </div >
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="state">State</label>
                <input class="form-control" type="text" name="state" value="<?php echo $state;?>"id="state" placeholder="Enter State">
            </div>
            <div class="form-group col-md-6">
                <label for="city">City</label>
                <input class="form-control" type="text" name="city" value="<?php echo $city;?>" id="city" placeholder="Enter City">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="male">Gender</label>
                <input class="form-control-md" type="radio"  <?php if(!empty($gender) && $gender=="Male") echo 'checked'; ?> name="gender" value="Male">Male
                <input class="form-control-md" type="radio" <?php if(!empty($gender) && $gender=="Female") echo 'checked'; ?> name="gender" value="Female">Female
            </div>
        </div>
      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="editprofile" class="btn btn-primary">Save changes</button>

        
      </div>
      </form>
    </div>
  </div>
</div>
  
            </div>
        </div>
    </div>
</div>
</body>
</html>