<?php
    $err="<br>";
    $success=false;
    session_start();
    require_once 'config.php';
    $userid=$_SESSION['id'];
    if(isset($_POST["submit"])){ 
        if(empty(trim($_POST['type']))){
            $err.="Please Select Product Type<br>";
        }
        else{
            $productType = $_POST['type'];
        }
        
        if(empty(trim($_POST['cname']))){
            $err.="Please Enter Product Name<br>";
        }
        else{
            $productName =$_POST['cname'];
        }

        if(empty(trim($_POST['cinfo']))){
            $err.="Please Enter Product Information<br>";
        }
        else{
            $productInfo = $_POST['cinfo'];
        }

        if(empty(trim($_POST['price'])) || trim($_POST['price'])<=0){
            $err.="Please Enter Product Price<br>";
        }
        else{
            $productPrice =$_POST['price'];
        }
        if(empty(trim($_POST['qty'])) || trim($_POST['qty'])<=0){
            $err.="Please Enter Product avaliable Quantity<br>";
        }
        else{
            $productQty =$_POST['qty'];
        }

        if(!empty($_FILES["croppic"]["name"]))
        {
            // Get file info 
            $fileName = basename($_FILES["croppic"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 

            // Allow certain file formats 
            $allowTypes = array('jpg','png','jpeg','gif'); 
            if(in_array($fileType, $allowTypes)){
                $image = $_FILES['croppic']['tmp_name']; 
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
            // Insert image content into database 
            $sql="INSERT INTO `product` (`pname`, `category`, `pinfo`, `price`, `image`,`userid`,`qty`) VALUES ('$productName', '$productType', '$productInfo', '$productPrice','$imgContent','$userid','$productQty')";
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
    <title>Selling</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item active"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
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
    <div class="container col-md-8 mt-4 shadow">
    <br>
        <div class="form-row">
            <div class="form-group col-md-6">
                <h1 class="text-primary">Upload crop</h1>
            </div>
            <div class="d-flex flex-row-reverse bd-highlight form-group col-md-6">
                    <!-- Button trigger modal -->
                    <a href="updateproduct.php">
                    <button type="button" class="btn btn-primary">
                    Add Quantity in existing Products
                    </button></a>
            </div>
        </div>        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cname">Crop name</label>
                    <input class="form-control" type="text" name="cname" id="cname" placeholder="Enter cname">
                </div>
                <div class="form-group col-md-6">
                    <label for="type">Select catagory:</label>
                    <select class="form-control" name="type" id="type">
                        <option value="Fruit" style="color: black;">Fruit</option>
                        <option value="Vegetable" style="color: black;">Vegetable</option>
                        <option value="Grains" style="color: black;">Grains</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="price">Price</label>
                    <input class="form-control" type="number" name="price" id="price" placeholder="Enter Price of 500 grams">
                </div>
                <div class="form-group col-md-4">
                    <label for="croppic">Upload an Image</label>
                    <input class="form-control" type="file" name="croppic" id="croppic"></input>
                </div>
                <div class="form-group col-md-4"> 
                    <label for="qty">Enter Quantity(in 500 grams packets)</label>
                    <input class="form-control" type="number" name="qty" id="qty" placeholder="Enter Quantity(no of packets 500 grams)">
                </div>
            </div>
            <div class="form-row"> 
                <div class="form-group col-md-10"> 
                    <label for="cinfo">Enter Information</label>
                    <textarea  name="cinfo" id="cinfo" rows="12"></textarea>
                </div>
            </div>
            <div class="form-row"> 
                <div class="form-group col-md-3"> 
                    <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </from>
    </div>
    <script>
		CKEDITOR.replace( 'cinfo' );
	</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>