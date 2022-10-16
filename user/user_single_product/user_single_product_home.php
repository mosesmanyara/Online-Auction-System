<?php
    session_start();
    require_once('../../includes/database.php');

    $userId = $_SESSION['user_id'];
    if(isset($_GET['productId'])) $_SESSION['user_single_productId'] = $_GET['productId'];
    $productId = $_SESSION['user_single_productId'];

    $status = "";
    if(isset($_POST['bid'])) {
        $query = "SELECT * FROM duration WHERE product_id='$productId' ";
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);
        $endTimestamp = $row['end_date'];
        date_default_timezone_set("Asia/Dhaka");
        $currentTimestamp = date('Y-m-d H:i:s');
        
        if($endTimestamp < $currentTimestamp) $status = "<p class='alert alert-warning'>Auction Time is Over !!</p>";
        else {
            $amount = $_POST['price'];
            $query = "INSERT INTO bid(product_id, user_id, amount, time) VALUES ('$productId', '$userId', '$amount', '$currentTimestamp') ";
            $result = mysqli_query($db, $query);
            if($result) $status = "<p class='alert alert-success'>Placed Bid Successfully !!</p>";
            else $status = "<p class='alert alert-warning'>Failed to Place Bid !!</p>";
            header("Refresh:1");
        }
    }
    
    $query1 = "SELECT * FROM product NATURAL JOIN product_status NATURAL JOIN user NATURAL JOIN product_category NATURAL JOIN duration WHERE product_id = '$productId' ";
    $query2 = "SELECT * FROM bid NATURAL JOIN user WHERE product_id = '$productId' ORDER BY time DESC LIMIT 1";
    $result1 = mysqli_query($db, $query1);
    $result2 = mysqli_query($db, $query2);
    $row1 = mysqli_fetch_array($result1);
    $row2 = mysqli_fetch_array($result2);

    $ownerName = $row1['user_name'];
    $duration = $row1['duration'];
    $endDate = $row1['end_date'];
    $category = $row1['category'];
    
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

    $lastBid = $row2['amount'];
    $lastBidderId = $row2['user_id'];
    $lastBidderName = $row2['user_name'];

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
            <?php echo $status ?>

            <h2><?php echo $productName?></h2>
            <h5><?php echo $category?></h5> <br>
            <p>
                Owned by: <?php echo $ownerName?> <br>
                Duration: <?php echo $duration ?> Days <br>
                Closes: <span class="h5"><?php echo $endDate?></span>
            </p>
            <hr />

            <div class="bid-section d-flex flex-row align-items-center">
                <div class="price col-md-5 pl-0">
                    Base Price: <br>
                    <span class="h4">$<?php echo $basePrice?></span> <br>
                    Last Bid: <br>
                    <span class="h4">$<?php echo $lastBid?></span> <br>
                    Bidder: <br>
                    <span class="h4">$<?php echo "$lastBidderName ($lastBidderId)"?></span> <br>

                </div>
                <div class="bid col-md-7">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="bid-price">Place Your Bid (higher than last bid)</label>
                        <input type="number" class="form-control" id="bid-price" min="<?php echo $lastBid+1 ?>" step=".01" pattern="^\d*(\.\d{0,2})?$" name="price" value="<?php echo $lastBid+1 ?>" placeholder="Max 2 decimal points" required>
                        <input class="btn btn-primary mt-2" type="submit" name="bid" value="Place Bid">
                    </form>
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