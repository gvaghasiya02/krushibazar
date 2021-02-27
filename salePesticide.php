<?php
    session_start();
    require_once 'config.php';
    $user_count=0;
    $sql="SELECT id,email,password FROM user";
    $result=$conn->query($sql);
    $user_count=$result->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
    <title>Home</title>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Welcome to Krushibazar</h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="salePesticide.php">Add Pesticides</a></li>
                <li class="nav-item"><a class="nav-link" href="historyPesticide.php">Pesticides History</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $_SESSION['email'];?></a></li>
            </ul>
            <ul class="nav navbar-nav">
                <li><a href="logout-admin.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <form
    <div class="container mt-4 shadow">
        <h1 class="text-primary">Upload Pesticide</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="pestname">Pesticide name</label>
                    <input class="form-control" type="text" name="pestname" id="pestname" placeholder="Enter Pesticide name">
                </div>
                <div class="form-group col-md-4">
                    <label for="price">Price</label>
                    <input class="form-control" type="number" name="price" id="price" placeholder="Enter Price">
                </div>
                <div class="form-group col-md-4">
                    <label for="pestpic">Upload an Image</label>
                    <input class="form-control" type="file" name="pestpic" id="pestpic"></input>
                </div>
                </div>
                <div class="form-row"> 
                <div class="form-group col-md-10"> 
                    <label for="pestinfo">Enter Information</label>
                    <textarea  name="pestinfo" id="pestinfo" rows="12"></textarea>
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
