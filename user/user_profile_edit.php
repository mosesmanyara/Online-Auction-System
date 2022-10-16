<?php 
    session_start();
    require_once('../includes/database.php');
    
    function filterInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    $id = $_SESSION["user_id"];
    $query = "SELECT * FROM user where user_id = '$id' ";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_array($result);
    
    $name = $row["user_name"];
    $email = $row["email"];
    $address = $row["address"];
    $city = $row["city"];
    $country = $row["country"];
    $countryCode = $row["country_code"];
    $registerHtml = "";
    $addressErr = $cityErr = $countryErr = $countryCodeErr = $status = "";

    if(isset($_POST['update'])) {

        $errCount = 0;
        $spaceRegex = "/\s\s+/";
        $countryCodeRegex = "/^\d{1,3}(-\d{3,4})?$/";

        // Address
        $address = filterInput($_POST['address']);
        $address = preg_replace($spaceRegex, ' ', $address);
        if(strlen($address) < 10) {
            $addressErr = "* Incomplete address";
            $errCount++;
        }

        // City
        $city = filterInput($_POST['city']);
        if(strlen($city) < 3) {
            $cityErr = "* Invalid city";
            $errCount++;
        }

        // Country
        $country = filterInput($_POST['country']);
        if(strlen($country) < 3) {
            $countryErr = "* Invalid country";
            $errCount++;
        }

        // Country Code
        $countryCode = filterInput($_POST["countryCode"]);
        if(!preg_match($countryCodeRegex, $countryCode)) {
            $countryCodeErr = "* Invalid country code";
            $errCount++;
        }

        if(! $errCount) {
            $query = "UPDATE user SET address='$address', city='$city', country='$country', country_code='$countryCode' WHERE user_id='$id' ";
            if(mysqli_query($db, $query)) {
                $status = "<p class='alert alert-success'>Account updated successfully !!</p>";
                header("Refresh:1; url=user_profile.php");
            }
            else $status = "<p class='alert alert-danger'>Update Failed !!</p>";
        }        
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

    <style>
        .pink {color: red;}
    </style>
</head>
<body>
    <?php
        if(isset($_GET['logout'])) {
            session_destroy();
            if(isset($_COOKIE["logout"])) setcookie("logout", 1, time() + (3600 * 24 * 30), "/");
            header("Refresh:0; url=../index.php");
        }
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-around p-0 mb-5">
        <a class="navbar-brand h1" href="user_home.php">
            <img src="../images/auction1.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="user_home.php"><i class="fas fa-home"></i> Home</a>
            <a class="nav-item nav-link mr-3" href="user_request_auction.php"><i class="fas fa-satellite-dish"></i> Request Auction</a>
            <a class="nav-item nav-link mr-3" href="user_arrangement.php"><i class="fas fa-layer-group"></i> Arrangements</a>
            <a class="nav-item nav-link mr-3" href="user_participation.php"><i class="far fa-chart-bar"></i> Participations</a>
            <a class="nav-item nav-link mr-3" href="user_win.php"><i class="fas fa-trophy"></i> Wins</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3 active" href="user_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>


    <main class="container">
        <?php echo $status ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="name">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="ex: Moses Manyara" value="<?php echo $name; ?>" minlength="5" maxlength="35" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="ex: osoro@gmail.com" value="<?php echo $email; ?>" minlength="8" maxlength="35" readonly>
                </div>
            </div>
            <div class="form-group">
                <label for="address">Address <span class="red">*</span></label>
                <input type="text" class="form-control" id="address" name="address" placeholder="ex: 00200-00100" value="<?php echo $address; ?>" required>
                <span class="pink"><?php echo $addressErr; ?></span>
                </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="city">City <span class="red">*</span></label>
                    <input type="text" class="form-control" id="city" name="city" maxlength="20" placeholder="ex: Nairobi" value="<?php echo $city; ?>" required>
                    <span class="pink"><?php echo $cityErr; ?></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="country">Country <span class="red">*</span></label>
                    <input type="text" class="form-control" id="country" name="country" maxlength="20" placeholder="ex: Kenya" value="<?php echo $country; ?>" required>
                    <span class="pink"><?php echo $countryErr; ?></span>
                </div>
                <div class="form-group col-md-4">
                    <label for="countryCode">Country Code <span class="red">*</span></label>
                    <input type="text" class="form-control" id="countryCode" name="countryCode" maxlength="7" placeholder="ex: 254" value="<?php echo $countryCode; ?>" required>
                    <span class="pink"><?php echo $countryCodeErr; ?></span>
                </div>
            </div>
            <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
        </form>
    </main>

    <?php include('../includes/footer.php'); ?>   
</body>
</html>