<?php
    $success=true; #Boolean variable to check if error occured
    $err="<br>"; # To store error
    session_start();
    #If user details exist in SESSION the redirect to home page
    if(isset($_SESSION['user']))
    {
        header('location:home.php');
        exit;
    }

    require_once("config.php");
    $email=$password="";
    $err="<br>";

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        #Check is username and password is empty
        if(empty(trim($_POST['email'])) || empty(trim($_POST['password'])))
        {
            $err.="Please enter Username and Password.";
            $success=false;
        }
        else
        {
            $email=trim($_POST['email']);
            $password=trim($_POST['password']);
        }

        #If no error then proceed further.
        if($err=="<br>")
        {
            #Retrive Details from database matching the entered Details
            $sql="SELECT id,email,password,firstname,lastname,address,state,city,phonenumber,gender,dob FROM user where email='$email'";
            $result=$conn->query($sql);
            if($result->num_rows==1)
            {
                $row = $result->fetch_assoc();
                #Check if password are equal.
                if(password_verify($password,$row['password']))
                {
                    require_once('./classes/user.php');
                    #Create a New Object of User Class
                    $user=new User($row["id"],$row["email"],$row["firstname"],$row["lastname"],$row["address"],$row["state"],$row["city"],$row["phonenumber"],$row["gender"],$row["dob"],'user');
                    #Store the user information in SESSION.
                    $_SESSION['user']=serialize($user);
                    $_SESSION['loggedin']='user';
                    #Redirect to home page
                    header('location:home.php');
                }
                else{
                    $err.="Please enter correct Password.";
                    $password="";
                    $success=false;
                }
            }
            else
            {
                $err.="Please enter correct Username.";
                $email="";
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
    <link rel="stylesheet" href="./styles/welcome_styles.css">
    <title>Login</title>
  </head>
<body>
    <div class="container mt-4 col-md-6">
    <h1>Login</h1>
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="username">Username<span class='text-danger'>*</span></label>
                <input type="email" class="form-control" name="email" value="<?php echo $email;?>" id="email" placeholder="Enter Email">
            </div>
            <div class="form-group col-md-12">
                <label for="password">Password<span class='text-danger'>*</span></label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password">
            </div>
            <div class="form-group col-md-12">
                <span class='text-danger'>* field are required</span>
            </div>
            <div class="form-group col-md-12">
                <?php 
                if($err!="<br>")
                {
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <strong>Failed </strong>Sign In Failed";
                    echo $err;
                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'  >&times;</span>
                    </button> 
                    </div>";
                }
                ?>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-primary col-md-2">Sign in</button>
                <label for="register">Not a Member?</label><a href="register.php" id="register">Register Here</a>
            </div>
        </div>  
    </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>