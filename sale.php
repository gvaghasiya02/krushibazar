<?php
 session_start();
require_once 'config.php';
if(isset($_POST["submit"])){ 
  $productType = $_POST['type'];
  $productName =$_POST['cname'];
  $productInfo = $_POST['cinfo'];
  $productPrice =$_POST['price'];
  #$imgContent = addslashes(file_get_contents($_FILES['croppic'])); 
  #echo $imgContent;
  $status = 'error'; 
  if(!empty($_FILES["croppic"]["name"])) { 
      // Get file info 
      echo $productType;
      $fileName = basename($_FILES["croppic"]["name"]); 
      $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
       
      // Allow certain file formats 
      $allowTypes = array('jpg','png','jpeg','gif'); 
      if(in_array($fileType, $allowTypes)){ 
          $image = $_FILES['croppic']['tmp_name']; 
          $imgContent = addslashes(file_get_contents($image)); 
          echo $productType;
          // Insert image content into database 
          $sql="INSERT INTO `product` (`cname`, `category`, `cinfo`, `price`, `image`) VALUES ('$productName', '$productType', '$productInfo', '$productInfo','$imgContent')";
          $insert = $conn->query($sql); 
           
          if($insert){ 
            echo "hi";
              $status = 'success'; 
              $statusMsg = "File uploaded successfully."; 
          }else{ 
              $statusMsg = "File upload failed, please try again."; 
          }  
      }else{ 
          $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
      } 
  }else{ 
      $statusMsg = 'Please select an image file to upload.'; 
  } 
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
    <title>Selling</title>
</head>
<body>
<div class="container">

  <h1 align="center">Welcome to Krushibazar</h1>
</div>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <ul class="nav navbar-nav mr-auto">
      <li class="active"><a href="home.php">Home</a></li>
      <li><a href="sale.php">Selling Crops</a></li>
      <li><a href="buying.php">Buying Crops</a></li>
      <li><a href="pesticides.php">Buying Pesticides</a></li>
      <li><a href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
      </ul>
      <ul class="nav navbar-nav">
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</nav>
<h1 class="text-primary">Upload crop</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cname">Crop name</label>
                <input class="form-control" type="text" name="cname" id="cname" placeholder="Enter cname">
            </div>
            <div class="form-group col-md-6">								  
                  <div class="form-group">
                  <label for="type">Select catagory:</label>
                  <select class="form-control" name="type" id="type">
                  <option value="Fruit" style="color: black;">Fruit</option>
								  <option value="Vegetable" style="color: black;">Vegetable</option>
								  <option value="Grains" style="color: black;">Grains</option>
                  </select>
                  </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="price">Price</label>
                <input class="form-control" type="number" name="price" id="price" placeholder="Enter Price">
            </div>
            <div class="form-group col-md-6">
                <label for="croppic">Upload an Image</label>
                <input type="file" name="croppic" id="croppic"></input>
            </div>
        </div>
        <div class="form-row"> 
        <div class="form-group col-md-10"> 
					<textarea  name="cinfo" id="cinfo" rows="12"></textarea>
        </div>
				</div>
        <div class="form-row"> 
        <div class="form-group col-md-3"> 
        <button type="submit" name="submit" class="btn btn-default">Upload</button>
        </div>
				</div>
      </from>
      <script>
			 CKEDITOR.replace( 'cinfo' );
		</script>
</body>
</html>
