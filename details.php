<?php
session_start();
require_once("config.php");
$firstname=$lastname=$dob=$address=$state=$city=$phonenumber=$gender="";
$username_err=$password_err=$confirm_pass_err="";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        //Check is username is empty
        if(empty(trim($_POST['firstname'])) && empty(trim($_POST['lastname'])) && empty(trim($_POST['dob'])) && empty(trim($_POST['address'])) && empty(trim($_POST['state'])) && empty(trim($_POST['city'])) && empty(trim($_POST['phonenumber'])) && empty(trim($_POST['gender'])))
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
            $sql="INSERT INTO userdetails(email,firstname,lastname,dob,address,state,city,phonenumber,gender) VALUES (?,?,?,?,?,?,?,?,?)";
            $stmt=mysqli_prepare($conn,$sql);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt,"sssssssss",$param_firstname,$param_lastname,$param_dob,$param_address,$param_state,$param_city,$param_phonenumber,$param_gender);
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
                    header("location:home.php");
                }
                else{
                    echo "Something is Wrong...cannot redirect.";
                }
            }
            mysqli_stmt_close($stmt);
        }
        //if no error
        if(empty($username_err) && empty($password_err) && empty($confirm_pass_err))
        {
            
        }
        mysqli_close($conn);
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
    
    <div class="container">
    <h1>Enter details</h1>
    <form action="" method="post">
        <div class="form-row">
            <label>FirstName</label>
            <input type="text" name="firstname" placeholder="Enter Firstname">
        </div>
        <div class="form-row">
            <label>LastName</label>
            <input type="text" name="firstname" placeholder="Enter lastname">
        </div>
        <div class="form-row">
            <label>Date Of Birth</label>
            <input type="text" name="firstname" placeholder="dob">
        </div>
        <div class="form-row">
            <label>Address</label>
            <input type="textarea" name="firstname" placeholder="address">
        </div >
        <div class="form-row">
            <label>State</label>
            <input type="text" name="firstname" placeholder="state">
        </div>
        <div class="form-row">
            <label>City</label>
            <input type="text" name="firstname" placeholder="city">
        </div>
        <div class="form-row">
            <label>Phone Number</label>
            <input type="number" name="firstname" placeholder="phonenumber">
        </div>
        <div class="form-row">
            <input type="radio" name="gender">
            <label>Male</label>
            <input type="radio" name="gender">
            <label>Female</label>
        </div>

    </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>