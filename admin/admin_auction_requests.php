<?php
    session_start();
    require_once('../includes/database.php');
    
    $minPrice = 0;
    $maxPrice = 100000;
    if(isset($_POST['filter'])) {
        $minPrice = $_POST['min-price'];
        $maxPrice = $_POST['max-price'];
    }

    $query = "SELECT * FROM product NATURAL JOIN product_status WHERE status='pending' ";
    $result = mysqli_query($db, $query);

    $count = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <title>Auction</title>
</head>

<body>
    <?php
        if(isset($_GET['logout'])) {
            session_destroy();
            if(isset($_COOKIE["logout"])) setcookie("logout", 1, time() + (3600 * 24 * 30), "/");
            header("Refresh:0; url=../index.php");
        }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between py-0 px-3 mb-5">
        <a class="navbar-brand h1" href="admin_home.php">
            <img src="../images/auction1.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="admin_home.php"><i class="fas fa-home"></i> Home</a>
            <a class="nav-item nav-link mr-3" href="admin_user_list.php"><i class="fas fa-address-book"></i> User List</a>
            <a class="nav-item nav-link mr-3 active" href="admin_auction_requests.php"><i class="fas fa-satellite-dish"></i> Auction Requests</a>
            <a class="nav-item nav-link mr-3" href="admin_refresh_status.php"><i class="fas fa-sync-alt"></i> Refresh Status</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="admin_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <main class="row">
        <div class="col-md-2 side-bar pt-0">
            <h3 class="category-heading text-center p-2">Filter</h3>
            <div class="category-list p-2">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="min-price">Min Price</label>
                    <input type="number" class="form-control" id="min-price" step=".01" pattern="^\d*(\.\d{0,2})?$" name="min-price" value="<?php echo $minPrice?>" required>
                     
                    <label for="max-price">Max Price</label>
                    <input type="number" class="form-control" id="max-price" step=".01" pattern="^\d*(\.\d{0,2})?$" name="max-price" value="<?php echo $maxPrice?>" required>
                    
                    <input class="btn btn-block btn-outline-primary mt-2" type="submit" name="filter" value="Search">
                </form>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="product-deck">
                <?php 
                while($row = mysqli_fetch_array($result)) { 
                    $productId = $row["product_id"];   
                    $name = $row["product_name"];
                    $basePrice = $row["base_price"];
                    $image = "../uploads/" . $row["image1"];

                    if(isset($_POST['filter'])) {
                        $minPrice = $_POST['min-price'];
                        $maxPrice = $_POST['max-price'];
                        if($basePrice < $minPrice || $basePrice > $maxPrice) continue;
                    }
                    $count++;

                    $query1 = "SELECT * FROM product_status NATURAL JOIN user WHERE product_id='$productId' ";
                    $result1 = mysqli_query($db, $query1);
                    $row1 = mysqli_fetch_array($result1);
                    $ownerId = $row1["user_id"];
                    $ownerName = $row1["user_name"];
                ?>
                    <div class="product">
                        <img src="<?php echo $image ?>" alt="">
                        <h4><?php echo $name ?></h4>
                        <h6><?php echo "Base Price: $$basePrice" ?></h6>
                        <h6><?php echo "Owner: $ownerName ($ownerId)" ?></h6>
                        <button class="btn btn-block btn-primary mt-4" onclick="window.location='admin_single_product/admin_single_product_accept.php?productId=<?php echo $productId?>'">Explore</button>
                    </div>
                <?php }

                if(! $count) echo "<p>No Result to show</p>";
                ?>   
            </div>        
        </div>
    </main>              

    <?php include('../includes/footer.php'); ?>   
</body>
</html>