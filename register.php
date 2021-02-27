<?php
$success=true;
require_once("config.php");
$email=$password=$confirm_pass="";
$err="<br>";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        //Check is username is empty
        if(empty(trim($_POST['email'])))
        {
            $err.="Email cannot be empty<br>";
        }
        else
        {
            $input_user=trim($_POST['email']);
            $sql="SELECT id FROM user WHERE email='$input_user'";
            //echo $sql;
            $result=$conn->query($sql);
            //var_dump($result);
            if($result->num_rows>0)
            {
                $err.="User with Same Email already taken<br>";
                $success=false;
            }
            else
            {
                $email=trim($_POST['email']);
            }
        }
        

        //check for pass
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
        }

        //Check if other fields are present
        if(empty(trim($_POST['firstname'])) || empty(trim($_POST['lastname'])) || empty(trim($_POST['dob'])) || empty(trim($_POST['address'])) || empty(trim($_POST['state'])) || empty(trim($_POST['city'])) || empty(trim($_POST['phonenumber'])) || empty($_POST['gender']))
        {
            $err.="Enter all details<br>";
            $success=false;
        }
        if(strlen((string)$_POST['phonenumber'])!=10)
        {
            $err.="Enter correct PhoneNumber<br>";
            $success=false;
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
            #echo $dob;
        }

        //if no error
        if($err=="<br>")
        {
            $sql="INSERT INTO user(email,password,firstname,lastname,dob,address,state,city,phonenumber,gender) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stmt=$conn->prepare($sql);
            $stmt->bind_param('ssssssssss',$param_email,$param_password,$param_firstname,$param_lastname,$param_dob,$param_address,$param_state,$param_city,$param_phonenumber,$param_gender);
            $param_email=$email;
            $param_password=$password;
            $param_firstname=$firstname;
            $param_lastname=$lastname;
            $param_dob=$dob;
            $param_address=$address;
            $param_state=$state;
            $param_city=$city;
            $param_phonenumber=$phonenumber;
            $param_gender=$gender;
            if($stmt->execute()==TRUE){
                header("location:login.php");
                $success=true;
            }
            else{
                echo "Error: " . $sql . "<br>" . $conn->error;
                $success=false;
            }
            $conn->close();
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Register</title>
</head>
<body>
<?php 
    if(!$success)
    {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Failed to Register</strong>";
        echo $err;
        echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'  >&times;</span>
        </button>  
        </div>";
    }
?>
    <div class="container shadow mt-4">
    <h1 class="text-primary">Register Here</h1>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname">FirstName</label>
                <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Enter First Name">
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">LastName</label>
                <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Enter Last Name">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dob">Date Of Birth</label>
                <input class="form-control" type="date" name="dob" id="dob" placeholder="Enter DOB">
            </div>
            <div class="form-group col-md-6">
                <label for="phonenumber">Phone Number</label>
                <input class="form-control" type="number" name="phonenumber" id="phonenumber" placeholder="Enter your Phone Number">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="address">Address</label>
                <input class="form-control" type="textarea" name="address" id="address" placeholder="Enter your Address">
            </div>
        </div >
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="state">State</label>
                <input class="form-control" type="text" name="state" id="state" placeholder="Enter State">
            </div>
            <div class="form-group col-md-6">
                <label for="city">City</label>
                <input class="form-control" type="text" name="city" id="city" placeholder="Enter City">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="male">Gender</label>
                <input class="form-control-md" type="radio" name="gender" value="Male">Male
                <input class="form-control-md" type="radio" name="gender" value="Female">Female
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Re-Enter Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-md-12">Sign Up</button>
        <label for="register">Aleady a Member?</label><a href="login.php" id="register">Sign In Here</a>
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>