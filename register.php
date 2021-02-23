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
            $sql="SELECT id FROM users WHERE email=?";
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
        }
        mysqli_stmt_close($stmt);

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

        //if no error
        if(empty($username_err) && empty($password_err) && empty($confirm_pass_err))
        {
            $sql="INSERT INTO users(email,password) VALUES (?,?)";
            $stmt=mysqli_prepare($conn,$sql);
            if($stmt)
            {
                mysqli_stmt_bind_param($stmt,"ss",$param_email,$param_password);
                $param_username=$email;
                $param_password=password_hash($password,PASSWORD_DEFAULT);
                //try to execute
                if(mysqli_stmt_execute($stmt))
                {
                    header("location:login.php");
                }
                else{
                    echo "Something is Wrong...cannot redirect.";
                }
            }
            mysqli_stmt_close($stmt);
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
    <div class="container mt-4">
    <h1>Register</h1>
    <form action="" method="post">
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