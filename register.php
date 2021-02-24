<?php
require_once("config.php");
$email=$password=$confirm_pass="";
$username_err=$password_err=$confirm_pass_err="";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        //Check is username is empty
        if(empty(trim($_POST['email'])))
        {
            $username_err="Email cannot be empty";
        }
        else
        {
            $sql="SELECT id FROM user WHERE email=?";
            $stmt=mysqli_prepare($conn,$sql);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt,"s",$param_email);

                //set the value of param
                $param_email=trim($_POST['email']);

                //try to execute this statement
                if(mysqli_stmt_execute($stmt))
                {
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt)==1)
                    {
                        $username_err="User with Same Email already taken";
                    }
                    else
                    {
                        $email=trim($_POST['email']);
                    }
                }
                else
                {
                    echo "Something went wrong";
                }
            }
            mysqli_stmt_close($stmt);
        }

        //check for pass
        if(empty(trim($_POST['password'])))
        {
            $password_err="Password cannot be empty";
        }
        elseif(strlen(trim($_POST['password']))<5)
        {
            $password_err="Password cannot be less than 5 characters";
        }
        else
        {
            $password=trim($_POST['password']);
        }

        //confirm password
        if(trim($_POST['password']) != trim($_POST['confirm_password']))
        {
            $password_err="Password should match";
        }

        //Check if other fields are present
        if(empty(trim($_POST['firstname'])) || empty(trim($_POST['lastname'])) || empty(trim($_POST['dob'])) || empty(trim($_POST['address'])) || empty(trim($_POST['state'])) || empty(trim($_POST['city'])) || empty(trim($_POST['phonenumber'])) || empty(trim($_POST['gender'])))
        {
            $username_err="Enter all details";
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
        }

        //if no error
        if(empty($username_err) && empty($password_err) && empty($confirm_pass_err))
        {
            
            $sql="INSERT INTO user(email,password,firstname,lastname,dob,address,state,city,phonenumber,gender) VALUES (?,?,?,?,?,?,?,?,?,?)";
            var_dump($conn);
            $stmt=mysqli_prepare($conn,$sql);
            var_dump($stmt);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt,"ssssssssss",$param_email,$param_password,$param_firstname,$param_lastname,$param_dob,$param_address,$param_state,$param_city,$param_phonenumber,$param_gender);
                $param_email=$email;
                $param_password=password_hash($password,PASSWORD_DEFAULT);
                $param_firstname=$firstname;
                $param_lastname=$lastname;
                $param_dob=$dob;
                $param_address=$address;
                $param_state=$state;
                $param_city=$city;
                $param_phonenumber=$phonenumber;
                $param_gender=$gender;
                
                //try to execute
                if(mysqli_stmt_execute($stmt))
                {
                    header("location:login.php");
                }
                else{
                    echo "Something is Wrong...cannot redirect.";
                }
            }
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
                <input class="form-control" type="text" name="dob" id="dob" placeholder="Enter DOB">
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
                <input type="text" class="form-control" name="email" id="email" placeholder="Enter Email">
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