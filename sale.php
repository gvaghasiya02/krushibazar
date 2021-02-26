<?php
session_start();?>
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
    <form action="" method="post">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cname">Crop name</label>
                <input class="form-control" type="text" name="cname" id="cname" placeholder="Enter cname">
            </div>
            <div class="form-group col-md-6">								  
                  <div class="form-group">
                  <label for="sel1">Select list (select one):</label>
                  <select class="form-control" id="sel1">
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
                <input class="form-control" type="file" name="croppic" id="croppic"></input>
            </div>
        </div>
        <div class="form-row"> 
        <div class="form-group col-md-10"> 
					<textarea  name="cinfo" id="cinfo" rows="12"></textarea>
        </div>
				</div>
        <div class="form-row"> 
        <div class="form-group col-md-3"> 
        <button type="button" class="btn btn-default">Upload</button>
        </div>
				</div>
      </from>
      <script>
			 CKEDITOR.replace( 'cinfo' );
		</script>
</body>
</html>
