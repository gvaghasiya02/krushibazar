<?php
    $err="";
    $er="";
    $comment="";
    $star="";
    $success=false;
    session_start();
    require_once('./classes/user.php');
    if(isset($_SESSION['user']))
    {
        $user=unserialize($_SESSION['user']);
        if($user->category!='user')
            header('location:logout.php');
    }
    else header('location:login.php');

    require_once('./classes/product.php');
    require_once 'config.php';
    if(isset($_POST['review']))
    {
        $pid=$_POST['pid'];
        if($_POST['star']=='0')
        {
            $err.="Please Select Stars";
            $er="Select Stars";
        }
        else $star=$_POST['star'];

        $comment=$_POST['comment'];

        if($err=="")
        {
            $s="SELECT * FROM rating WHERE pid='$pid' and userid='$user->userid'";
            $reviewed=$conn->query($s);
            if($reviewed->num_rows!=0)
            {
                $sql="UPDATE rating set star='$star',comment='$comment' WHERE pid='$pid' and userid='$user->userid'";
            }
            else $sql="INSERT INTO rating(pid,userid,star,comment) VALUES ('$pid','$user->userid','$star','$comment')";
            $insert=$conn->query($sql);
            if($insert)
            {
                $success=true;
            }
        }
    }
    $star5=$star4=$star3=$star2=$star1=$userCount=0; 
        $pid=$_POST['pid'];
        $sql="SELECT `pname`,`category`,`pinfo`,`price`,`image`,`userid`,`pid`,`qty` FROM product where pid='$pid'";
        $result=$conn->query($sql);
        $row=$result->fetch_assoc();
        $product=new Product($row['pid'],$row['pname'],$row['category'],$row['pinfo'],$row['price'],$row['image'],$row['userid'],$row['qty']);
        $sql="SELECT * from rating natural join user WHERE pid='$pid' and user.id=rating.userid";
        $review=$conn->query($sql);
        $userCount=$review->num_rows;
        if($userCount!=0)
        {
            $comments=array();
            while($row=$review->fetch_assoc())
            {
                if($row['star']==5)
                {
                    $star5++;
                }
                elseif($row['star']==4)
                {
                    $star4++;
                }
                elseif($row['star']==3)
                {
                    $star3++;
                }
                elseif($row['star']==2)
                {
                    $star2++;
                }
                elseif($row['star']==1)
                {
                    $star1++;
                }
                array_push($comments,$row);
            }
            $totalRating=$star5*5+$star4*4+$star3*3+$star2*2+$star1;
            $avgRating=$totalRating/$userCount;
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product->pname;?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.8.0/full/ckeditor.js"></script>
    <style>
        .fa {
            font-size: 25px;
            color:grey;
            display:inline;
        }
        .checked {
            color: orange;
        }
        .bar-container {
  width: 100%;
  background-color:#f1f1f1;
  text-align: center;
  color: white;
}
.span {
    font-size:18px;
}
.bar{ height: 18px; background-color: #4CAF50;}
.side {
  float: left;
  width: 15%;
  margin-top:10px;
}

.middle {
  margin-top:10px;
  float: left;
  width: 70%;
}

/* Place text to the right */
.right {
  text-align: right;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <img src="https://cdn.discordapp.com/attachments/809280919991091212/824313211875622963/1d4f1ba8-89b8-476e-9de4-e15e896c81c9.png" width="50" alt="">
        <div class="container-fluid">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active"><a class="nav-link" href="home.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="sale.php">Selling Crops</a></li>
                <li class="nav-item"><a class="nav-link" href="buying.php">Buying Products</a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php">logged in as:<?php echo $user->email;?></a></li>
            </ul>
            <ul class="nav navbar-nav">
            <li class="nav-item"><a  class="nav-link" href="cart.php">My Cart</a></li>
            <li class="nav-item"><a  class="nav-link" href="listorders.php">Your Orders</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container shadow my-4 content-center">
        <div class="row py-3">
            <div class="col-md-4">
                <img class='card-img-top' src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($product->image); ?>" alt='Card image cap'>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h4><?php echo $product->pname;?></h4>
                    </div>
                    <div class="col-md-12">
                        <h5>Category : <?php echo $product->category;?></h5>
                    </div>
                    <div class="col-md-12">
                        <h6>About : <?php echo $product->pinfo;?></h6>
                    </div>
                    <div class="col-md-12">
                        <h5>Price : <?php echo $product->price;?>₹</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>     
    <div class='container shadow p-3'>       
        <div class="row">
        <?php 
            if($userCount!=0){ ?>
                <div class="col-md-12 content-center text-center">
                    <div class="row">
                        <div class="col-md-12 text-left"><h3>Ratings</h3></div>
                        <div class="col-md-4">
                        <p><h5><?php echo $avgRating; ?>&nbsp;<i class="fa fa-star checked"></i></h5> based on <?php echo $userCount; ?> reviews</p>
                            <i class="fa fa-star <?php if($avgRating>=1) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($avgRating>=2) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($avgRating>=3) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($avgRating>=4) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($avgRating==5) echo 'checked'; ?>"></i>
                        </div>
                        <div class="col-md-6"> 
                                <div class="side">
                                    <div>5 star</div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container"><div class="bar mw-100" style="width:<?php echo round($star5*100/$userCount);?>%;"></div></div>
                                </div>
                                <div class="side right">
                                    <div><?php echo $star5; ?> Users</div>
                                </div>
                                <div class="side">
                                    <div>4 star</div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container"><div class="bar mw-100" style="width:<?php echo round($star4*100/$userCount);?>%;"></div></div>
                                </div>
                                <div class="side right">
                                    <div><?php echo $star4; ?> Users</div>
                                </div>
                                <div class="side">
                                    <div>3 star</div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container"><div class="bar mw-100" style="width:<?php echo round($star3*100/$userCount);?>%;"></div></div>
                                </div>
                                <div class="side right">
                                    <div><?php echo $star3; ?> Users</div>
                                </div>
                                <div class="side">
                                    <div>2 star</div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container"><div class="bar mw-100" style="width:<?php echo round($star2*100/$userCount);?>%;"></div></div>
                                </div>
                                <div class="side right">
                                    <div><?php echo $star2; ?> Users</div>
                                </div>
                                <div class="side">
                                    <div>1 star</div>
                                </div>
                                <div class="middle">
                                    <div class="bar-container"><div class="bar mw-100" style="width:<?php echo round($star1*100/$userCount);?>%;"></div></div>
                                </div>
                                <div class="side right">
                                    <div><?php echo $star1; ?> Users</div>
                                </div>
                        </div>                            
                    </div>
                </div>
                <?php }
             ?>
        
            <div class="col-md-12">
            <h3>Rate the Product</h3>
            <form action="" method="post">
                <input type="hidden" name="pid" value=<?php echo $product->pid; ?>>
                <div class="form-row">
                    <div class="form-group col-md-10">
                        <label for="comment">Comment</label>
                        <textarea name="comment" id="comment" rows=5 placeholder="Enter Comment"><?php if($err!="") echo $comment;?></textarea>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="star">Select Stars<span class='text-danger'>*</span></label>
                            <select class="form-control" value="<?php echo $star;?>" name="star" id="star">
                                <option value="0"  style="color: black;">Select Star</option>
                                <option value="1"  style="color: black;">1</option>
                                <option value="2"  style="color: black;">2</option>
                                <option value="3"  style="color: black;">3</option>
                                <option value="4"  style="color: black;">4</option>
                                <option value="5"  style="color: black;">5</option>
                            </select>
                    </div>
                    <div class='col-md-12'>
                        <?php 
                            if($success)
                            {?>
                                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                                <strong>Success</strong> Your Reviewed has been added.
                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                    <span aria-hidden='true'>&times;</span>
                                </button>
                                </div>
                            <?php
                            }
                            elseif($err!="")
                            {?>
                                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                <strong>Failed </strong><?php echo $err; ?><button type="button" class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times</span>
                                </button>  
                                </div>
                            <?php }
                        ?>
                    </div>
                    <div class="form-group d-flex justify-content-center col-md-12"> 
                        <button type="submit" name="review" class="btn btn-primary">Submit Review</button>
                    </div>
                </div>
            </form>
            </div>        
        </div>
    </div>
    <br>
    <div class='container p-5 shadow'>
        <div class="row">
            <div class="col-md-12"><h3>Reviews</h3></div>
                <?php 
                if($userCount!=0){
                    for($i=0;$i<10 && $i<count($comments);$i++) {?>
                        <div class="my-1 card bg-light col-md-12 shadow-sm"><div class='my-1 d-flex flex-row '>
                            <i class="fa fa-star <?php if($comments[$i]['star']>=1) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($comments[$i]['star']>=2) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($comments[$i]['star']>=3) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($comments[$i]['star']>=4) echo 'checked'; ?>"></i>
                            <i class="fa fa-star <?php if($comments[$i]['star']==5) echo 'checked'; ?>"></i></div>
                            <?php echo $comments[$i]['comment'];?>
                            <p align='right' class='font-italic font-weight-bold'>by <?php echo $comments[$i]['email']?></p></div>
                <?php
                } }
                 else
                 {
                    echo "<div class='my-1 text-center col-md-12'><h4>No Reviews Yet</h4></div>";
                 } ?>
            </div>
        </div>
            
    </div>
    <script>
		CKEDITOR.replace( 'comment' );
	</script>
</body>
</html>