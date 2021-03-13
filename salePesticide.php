<?php
    $err="<br>";
    $success=false;
    session_start();
    if( $_SESSION['loggedin']!="admin" || !isset($_SESSION['email']))
    {
        header('location:login.php');
    }
    require_once 'config.php';
    $user_count=0;
    $sql="SELECT id,email,password FROM user";
    $result=$conn->query($sql);
    $user_count=$result->num_rows;
    if(isset($_POST["submit"])){ 
        if(empty(trim($_POST['pestname']))){
            $err.="Please Enter Pesticide Name<br>";
        }
        else{
            $productName =$_POST['pestname'];
        }

        if(empty(trim($_POST['pestinfo']))){
            $err.="Please Enter Pesticide Information<br>";
        }
        else{
            $productInfo = $_POST['pestinfo'];
        }
        if(empty(trim($_POST['pqty'])) || trim($_POST['pqty'])<=0){
            $err.="Please Enter Product vaild avaliable Quantity<br>";
        }
        else{
            $productQty =$_POST['pqty'];
        }

        if(empty(trim($_POST['price'])) || trim($_POST['price'])<=0){
            $err.="Please Enter Pesticide Price<br>";
        }
        else{
            $productPrice =$_POST['price'];
        }
        

        if(!empty($_FILES["pestpic"]["name"]))
        {
            // Get file info 
            $fileName = basename($_FILES["pestpic"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 

            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){
                $image = $_FILES['pestpic']['tmp_name']; 
                $imgContent = addslashes(file_get_contents($image)); 
            }
            else{
                $err.="Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.<br>";
            }
        }
        else
        {
            $err.="Please Select an Image<br>";
        }
        
        if($err=="<br>")
        {
            $category="Pesticide";
            // Insert image content into database 
            $sql="INSERT INTO `product` (`pname`, `pinfo`, `price`, `image`,`category`,`userid`,`qty`) VALUES ('$productName', '$productInfo', '$productPrice','$imgContent','$category','9','$productQty')";
            $insert = $conn->query($sql);

            if($insert)
            {
                $success=true;
            }
            else{
                $err.="Failed to Upload the Details<br>";
            }
        }
    } 
    $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
    <title>addpesticide</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="home-admin.php">Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="salePesticide.php">Add Pesticides</a></li>
                <li class="nav-item"><a class="nav-link" href="historyPesticide.php">Pesticides History</a></li>
                <li class="nav-item"><a class="nav-link">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <?php 
        if($success)
        {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success</strong> Product Addedd Successfully.<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'  >&times</span>
            </button>  
            </div>";
        }
        elseif($err!="<br>")
        {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Failed to Add the Product</strong>";
            echo $err;
            echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'  >&times;</span>
            </button> 
            </div>";
        }
    ?>
    <div class="container mt-4 col-md-8 shadow">
        <br>
        <div class="form-row">
            <div class="form-group col-md-6">
                <h1 class="text-primary">Add Pesticide</h1>
            </div>
            <div class="d-flex flex-row-reverse bd-highlight form-group col-md-6">
                    <!-- Button trigger modal -->
                    <a href="updatepesticides.php">
                    <button type="button" class="btn btn-primary">
                    Add Quantity in existing Pesticides
                    </button></a>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="pestname">Pesticide name</label>
                    <input class="form-control" type="text" name="pestname" id="pestname" placeholder="Enter Pesticide name">
                </div>
                <div class="form-group col-md-6">
                    <label for="price">Price</label>
                    <input class="form-control" type="number" name="price" id="price" placeholder="Enter Price">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="pqty">Enter Quantity</label>
                    <input class="form-control" type="number" name="pqty" id="pqty" placeholder="Enter Quantity">
                </div>
                <div class="form-group col-md-6">
                <label for="pestpic">Upload an Image</label>
                    <input class="form-control" type="file" name="pestpic" id="pestpic"></input>
                    </div>
            </div>
                <div class="form-row"> 
                <div class="form-group col-md-10"> 
                    <label for="pestinfo">Enter Information</label>
                    <textarea name="pestinfo" id="pestinfo" rows="12"></textarea>
                </div>
            </div>
            <div class="form-row"> 
                <div class="form-group col-md-3"> 
                    <button type="submit" name="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </from>
    </div>
    <script>
		CKEDITOR.replace( 'pestinfo' );
	</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
