<?php
    session_start();
    require_once('../../includes/database.php');

    if(isset($_GET['productId'])) $_SESSION['user_single_productId'] = $_GET['productId'];
    $productId = $_SESSION['user_single_productId'];
    
    $query1 = "SELECT * FROM product NATURAL JOIN product_status NATURAL JOIN user WHERE product_id = '$productId' ";
    $result1 = mysqli_query($db, $query1);
    $row1 = mysqli_fetch_array($result1);

    $ownerName = $row1['user_name'];
    $duration = $row1['duration'];
    
    $productName = $row1['product_name'];
    $basePrice = $row1['base_price'];
    $image1 = $row1['image1'];
    $image2 = $row1['image2']; 
    $image3 = $row1['image3'];
    $description1 = $row1['description1'];
    $description2 = $row1['description2'];
    $description3 = $row1['description3'];
    $description4 = $row1['description4'];
    $description5 = $row1['description5'];

    $displayImage = $image1;
    if(isset($_GET['productImage1'])) $displayImage = $image1;
    if(isset($_GET['productImage2'])) $displayImage = $image2;
    if(isset($_GET['productImage3'])) $displayImage = $image3;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/all.min.css">
    <link rel="stylesheet" href="../../css/fontawesome.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="shortcut icon" href="../../images/logo.png" type="image/x-icon">
    <title>Auction</title>
</head>
<body>
    <?php
        if(isset($_GET['logout'])) {
            session_destroy();
            if(isset($_COOKIE["logout"])) setcookie("logout", 1, time() + (3600 * 24 * 30), "/");
            header("Refresh:0; url=../../index.php");
        }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-around p-0 mb-5">
        <a class="navbar-brand h1" href="../user_home.php">
            <img src="../../images/auction1.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="../user_home.php"><i class="fas fa-home"></i> Home</a>
            <a class="nav-item nav-link mr-3" href="../user_request_auction.php"><i class="fas fa-satellite-dish"></i> Request Auction</a>
            <a class="nav-item nav-link mr-3" href="../user_arrangement.php"><i class="fas fa-layer-group"></i> Arrangements</a>
            <a class="nav-item nav-link mr-3" href="../user_participation.php"><i class="far fa-chart-bar"></i> Participations</a>
            <a class="nav-item nav-link mr-3" href="../user_win.php"><i class="fas fa-trophy"></i> Wins</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="../user_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    
    <main class="container d-flex flex-row">
        <div class="image-section col-md-6">
            <div class="display-image text-center">
                <img src=<?php echo '../../uploads/' . $displayImage ?> alt="">
            </div>
            <div class="mini-image text-center">
                <a href="<?php echo $_SERVER['PHP_SELF'] . '?productImage1=true' ?>">
                    <img src=<?php echo '../../uploads/' . $image1 ?> alt="">
                </a>
                <a href="<?php echo $_SERVER['PHP_SELF'] . '?productImage2=true' ?>">
                    <img src=<?php echo '../../uploads/' . $image2 ?> alt="">
                </a>
                <a href="<?php echo $_SERVER['PHP_SELF'] . '?productImage3=true' ?>">
                    <img src=<?php echo '../../uploads/' . $image3 ?> alt="">
                </a>
            </div>
        </div>
        <div class="description-section col-md-6">
            <h2><?php echo $productName?></h2>
            <p>
                Owned by: <?php echo $ownerName?> <br>
                Duration: <?php echo $duration ?> Days
            </p>
            <hr />

            <div class="bid-section d-flex flex-row align-items-center">
                <div class="price col-md-5 pl-0">
                    Base Price: <br>
                    <span class="h4">$<?php echo $basePrice?></span> <br>
                </div>
                <div class="bid col-md-7">
                    <h5 class="text-center">Auction Status: Pending Approval</h5>
                </div>
            </div>
            <hr />

            <ul>
                <li><?php echo $description1?></li>
                <li><?php echo $description2?></li>
                <li><?php echo $description3?></li>
                <li><?php echo $description4?></li>
                <li><?php echo $description5?></li>
            </ul>
        </div>
    </main>
        
    <?php include('../../includes/footer.php'); ?>  
</body>
</html>