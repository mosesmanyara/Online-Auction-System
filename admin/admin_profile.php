<?php
    session_start();
    include("../includes/database.php");
    
    if(isset($_POST['editProfile'])) header('Refresh:0; url=admin_profile_edit.php');
    if(isset($_POST['changePassword'])) header('Refresh:0; url=admin_change_password.php');

   
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

    <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-around p-0 mb-5">
        <a class="navbar-brand h1" href="admin_home.php">
            <img src="../images/auction1.png" width="150" height="60" class="d-inline-block align-top" alt="">
        </a>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="admin_home.php"><i class="fas fa-home"></i> Home</a>
            <a class="nav-item nav-link mr-3" href="admin_user_list.php"><i class="fas fa-address-book"></i> User List</a>
            <a class="nav-item nav-link mr-3" href="admin_auction_requests.php"><i class="fas fa-satellite-dish"></i> Auction Requests</a>
            <a class="nav-item nav-link mr-3" href="admin_refresh_status.php"><i class="fas fa-sync-alt"></i> Refresh Status</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3 active" href="admin_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>


    <main class="container">
        <br><h1 class="text-center">PROFILE</h1><br>

        <ul class="list-group">
            <li class="list-group-item">ID            : <?php echo $row['user_id'] ?> </li>
            <li class="list-group-item">Name          : <?php echo $row['user_name'] ?> </li>
            <li class="list-group-item">Email         : <?php echo $row['email'] ?> </li>
            <li class="list-group-item">City          : <?php echo $row['city'] ?> </li>
            <li class="list-group-item">Country       : <?php echo $row['country'] ?> </li>
            <li class="list-group-item">Country Code  : <?php echo $row['country_code'] ?> </li>
            <li class="list-group-item">Gender        : <?php echo $row['gender'] ?> </li>
            <li class="list-group-item">Date of Birth : <?php echo $row['dob'] ?> </li>
            <li class="list-group-item">Age           : <?php echo $row['age'] ?> </li>
            <li class="list-group-item">Address       : <?php echo $row['address'] ?> </li>
        </ul>

        <br><br>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
           <button class="btn btn-primary" name="editProfile">Edit Profile</button>
           <button class="btn btn-primary" name="changePassword">Change Password</button>
       </form>
    </main>

    <?php include('../includes/footer.php'); ?>   
</body>
</html>
