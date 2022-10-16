<?php
    session_start();
    require_once('../includes/database.php');

    $minPrice = 0;
    $maxPrice = 100000;
    if(isset($_POST['filter'])) {
        $minPrice = $_POST['min-price'];
        $maxPrice = $_POST['max-price'];
    }
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
        <a class="navbar-brand h1" href="user_home.php">
            <img src="../images/auction1.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="user_home.php"><i class="fas fa-home"></i> Home</a>
            <a class="nav-item nav-link mr-3" href="user_request_auction.php"><i class="fas fa-satellite-dish"></i> Request Auction</a>
            <a class="nav-item nav-link mr-3 active" href="user_arrangement.php"><i class="fas fa-layer-group"></i> Arrangements</a>
            <a class="nav-item nav-link mr-3" href="user_participation.php"><i class="far fa-chart-bar"></i> Participations</a>
            <a class="nav-item nav-link mr-3" href="user_win.php"><i class="fas fa-trophy"></i> Wins</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="user_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>


    <main class="row">
        <div class="col-md-2 side-bar pt-0">
            <h3 class="category-heading text-center p-2">Category</h3>
            <div class="category-list">
                <a href="<?php echo $_SERVER['PHP_SELF'] ?>" class="category-item">All Category</a>
                <?php 
                    $c_query = "SELECT DISTINCT category FROM product_category";
                    $c_result = mysqli_query($db, $c_query);

                    while($c_row = mysqli_fetch_array($c_result)) {
                        echo '<a href="' . $_SERVER['PHP_SELF'] . '?category=' . $c_row['category'] . '" class="category-item">' . $c_row['category'] . '</a>';
                    }
                ?>
            </div>

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
            <h4>Status: Pending</h4> 
            <hr />
            <?php include('user_includes/user_arrangement_pending.php'); ?>    
            <br />

            <h4>Status: Ongoing</h4> 
            <hr />
            <?php include('user_includes/user_arrangement_ongoing.php'); ?>    
            <br />

            <h4>Status: Closed</h4>
            <hr />
            <?php include('user_includes/user_arrangement_closed.php'); ?>    
        </div>
    </main>
    
    <?php include('../includes/footer.php'); ?>    
</body>
</html>