<?php
    session_start();

    if(isset($_SESSION['email']))
    {
        header('location:home.php');
        exit;
    }

    require_once("config.php");
    $email=$password="";
    $err="";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        //Check is username is empty
        if(empty(trim($_POST['email'])) || empty(trim($_POST['password'])))
        {
            $err="Please enter Username and Password.";
            echo $err;
        }
        else
        {
            $email=trim($_POST['email']);
            $password=trim($_POST['password']);
        }
        if(empty($err))
        {
            $sql="SELECT id,email,password FROM adminuser where email=?";
            $stmt=mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt,"s",$param_email);
            $param_email=trim($_POST['email']);

            //try to execute this statement
            if(mysqli_stmt_execute($stmt))
            {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt)==1)
                {
                    mysqli_stmt_bind_result($stmt,$id,$email,$hashed_pass);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        //print_r($stmt);
                        if($password==$hashed_pass)
                        {
                            session_start();
                            $_SESSION['id']=$id;
                            $_SESSION['email']=$email;
                            $_SESSION['loggedin']=true;
                            header('location:home-admin.php');
                        }
                    }
                }
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
    <link rel="stylesheet" href="./styles/welcome_styles.css">
    <title>Register</title>
  </head>
  <body>
    <div class="container mt-4">
    <h1>Login</h1>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-12">
            <label for="username">Username</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
            </div>
            <div class="form-group col-md-12">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary col-md-12">Sign in</button>
        <label for="register">Not a Member?</label><a href="register.php" id="register">Register Here</a>
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>