<?php
$success=true;
require_once("config.php");
$email=$password=$confirm_pass=$firstname=$lastname=$dob=$address=$state=$city=$phonenumber=$gender="";
$err=$email_err=$pass_err=$fname_err=$lname_err=$dob_err=$address_err=$state_err=$city_err=$pno_err=$gender_err="";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        //Check is Email is empty
        if(empty(trim($_POST['email'])))
        {
            $email_err.="Email cannot be empty";
        }
        else
        {
            $input_user=trim($_POST['email']);
            #Check if user with similar email already exists.
            $sql="SELECT id FROM user WHERE email='$input_user'";
            $result=$conn->query($sql);
            if($result->num_rows>0)
            {
                $email_err.="User with Same Email already taken";
                $success=false;
            }
            else
            {
                $email=trim($_POST['email']);
            }
        }
        

        //check for password
        if(empty(trim($_POST['password'])))
        {
            $pass_err.="Password cannot be empty";
            $success=false;
        }
        elseif(strlen(trim($_POST['password']))<5)
        {
            $pass_err.="Password cannot be less than 5 characters";
            $success=false;
        }
        elseif(trim($_POST['password']) != trim($_POST['confirm_password']))
        {
            $pass_err.="Password should match";
            $success=false;
        }
        else
        {
            $password=password_hash(trim($_POST['password']),PASSWORD_DEFAULT);
        }

        //Check for Firstname
        if(empty(trim($_POST['firstname'])))
        {
            $fname_err.="Enter First Name";
            $success=false;
        }
        else{
            $firstname=$_POST['firstname'];
        }

        //Check for Lastname
        if(empty(trim($_POST['lastname'])))
        {
            $lname_err.="Enter Last Name";
            $success=false;
        }
        else{
            $lastname=$_POST['lastname'];
        }

        //Check for DOB
        if(empty(trim($_POST['dob'])))
        {
            $dob_err.="Enter Date of Birth";
            $success=false;
        }
        elseif(round((strtotime(date("D F Y"))-(strtotime($_POST['dob'])))/(31540000))<18)
        {
            $dob_err.="You Should be 18";
            $success=false;
        }
        else{
            $dob=$_POST['dob'];
        }

        //Check for Address
        if(empty(trim($_POST['address'])))
        {
            $address_err.="Enter Address";
            $success=false;
        }
        else{
            $address=$_POST['address'];
        }

        //Check for State
        if(empty(trim($_POST['state'])))
        {
            $state_err.="Enter State";
            $success=false;
        }
        else{
            $state=$_POST['state'];
        }

        //Check for City
        if(empty(trim($_POST['city'])))
        {
            $city_err.="Enter City";
            $success=false;
        }
        else{
            $city=$_POST['city'];
        }

        //Check for Phone Number
        if(empty(trim($_POST['phonenumber'])))
        {
            $pno_err.="Enter Phone Number";
            $success=false;
        }
        elseif(strlen((string)$_POST['phonenumber'])!=10)
        {
            $pno_err.="Phonenumber should be of 10 digits";
            $success=false;
        }
        else{
            $phonenumber=$_POST['phonenumber'];
        }

        //Check for Gender
        if(!isset($_POST['gender']))
        {
            $gender_err.="Enter Gender";
            $success=false;
        }
        else{
            $gender=$_POST['gender'];
        }

        //if no error
        if(empty($err) && empty($email_err) && empty($pass_err) && empty($fname_err) && empty($lname_err) && empty($dob_err) && empty($address_err) && empty($city_err) && empty($pno_err) && empty($gender_err))
        {
            #Add the New User and redirect to login page
            $sql="INSERT INTO user(email,password,firstname,lastname,dob,address,state,city,phonenumber,gender) VALUES ('$email','$password','$firstname','$lastname','$dob','$address','$state','$city','$phonenumber','$gender')";
            $stmt=$conn->query($sql);
            if($stmt){
                header("location:login.php");
                $success=true;
            }
            else{
                echo "Error: " . $sql . "<br>" . $conn->error;
                $success=false;
            }
        }
    }
    $conn->close();
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
    <div class="container shadow my-4">
    <h1 class="text-primary">Register Here</h1>
    <span class='text-danger'>* field are required</span>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname">FirstName</label><span class='text-danger'>*</span>
                <input class="form-control" type="text" name="firstname" id="firstname" value='<?php echo $firstname; ?>' placeholder="Enter First Name">
                <span class='text-danger'><?php echo $fname_err; ?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">LastName</label><span class='text-danger'>*</span>
                <input class="form-control" type="text" name="lastname" id="lastname" value='<?php echo $lastname; ?>' placeholder="Enter Last Name">
                <span class='text-danger'><?php echo $lname_err; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="dob">Date Of Birth</label><span class='text-danger'>*</span>
                <input class="form-control" type="date" name="dob" id="dob" value='<?php echo $dob; ?>' placeholder="Enter DOB(age must be 18)">
                <span class='text-danger'><?php echo $dob_err; ?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="phonenumber">Phone Number</label><span class='text-danger'>*</span>
                <input class="form-control" type="number" name="phonenumber" id="phonenumber" value='<?php echo $phonenumber; ?>' placeholder="Enter your Phone Number">
                <span class='text-danger'><?php echo $pno_err; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="address">Address</label><span class='text-danger'>*</span>
                <input class="form-control" type="textarea" name="address" id="address" value='<?php echo $address; ?>' placeholder="Enter your Address">
                <span class='text-danger'><?php echo $address_err; ?></span>
            </div>
        </div >
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="state">State</label><span class='text-danger'>*</span>
                <input class="form-control" type="text" name="state" id="state" value='<?php echo $state; ?>' placeholder="Enter State">
                <span class='text-danger'><?php echo $state_err; ?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="city">City</label><span class='text-danger'>*</span>
                <input class="form-control" type="text" name="city" id="city" value='<?php echo $city; ?>' placeholder="Enter City">
                <span class='text-danger'><?php echo $city_err; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="male">Gender</label><span class='text-danger'>*</span>
                <input class="form-control-md" type="radio" name="gender" <?php if(!empty($gender) && $gender=="Male") echo 'checked'; ?> value="Male">Male
                <input class="form-control-md" type="radio" name="gender" <?php if(!empty($gender) && $gender=="Female") echo 'checked'; ?>value="Female">Female
                <span class='text-danger'><?php echo $gender_err; ?></span>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="email">Email</label><span class='text-danger'>*</span>
                <input type="email" class="form-control" name="email" id="email" value='<?php echo $email; ?>' placeholder="Enter Email">
                <span class='text-danger'><?php echo $email_err; ?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label><span class='text-danger'>*</span>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
                <span class='text-danger'><?php echo $pass_err; ?></span>
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirm Password</label><span class='text-danger'>*</span>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Re-Enter Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-md-12">Sign Up</button>
        <label for="register">Already a Member?</label><a href="login.php" id="register">Sign In Here</a>
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>