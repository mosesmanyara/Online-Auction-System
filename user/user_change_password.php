<?php 
    session_start();
    require_once("../includes/database.php");
    $id = $_SESSION['user_id'];
    
    $countErr = 0;
    $currentPasswordErr = $newPasswordErr = $confirmNewPasswordErr = $status = "";

    if(isset($_POST['update'])) {
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmNewPassword = $_POST['confirmNewPassword'];

        $query = "SELECT * FROM user WHERE user_id='$id' "; 
        $result = mysqli_query($db, $query);
        $row = mysqli_fetch_array($result);
        $dbPassword = $row['password'];

        if(! password_verify($currentPassword, $dbPassword)) {
            $currentPasswordErr = "Current password doesn't match";
            $countErr++;
        }
        if($currentPassword === $newPassword) {
            $newPasswordErr = "New Password Can Not Be Old Password";
            $countErr++;
        }
        if($newPassword !== $confirmNewPassword) {
            $confirmNewPasswordErr = "Doesn't match with new password";
            $countErr++;
        }

        if(! $countErr) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query = "UPDATE user SET password='$hashedPassword' WHERE user_id='$id' ";
            if(mysqli_query($db, $query)) $status = "<p class='alert alert-success'>Password Changed Successfully !!</p>";
            else $status = "<p class='alert alert-danger'>Couldn't Change Password !!</p>";

            header("Refresh:1; url=user_profile.php");
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
        <a class="navbar-brand h1" href="#">
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


    <main class="container mt-5">
        <?php echo $status; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group row">
                <label for="currentPassword" class="col-sm-3 col-form-label">Current Password</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="currentPassword" id="currentPassword" required>
                    <span class="pink"><?php echo $currentPasswordErr; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="newPassword" class="col-sm-3 col-form-label">New Password</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="newPassword" id="newPassword" required>
                    <span class="pink"><?php echo $newPasswordErr; ?></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="confirmNewPassword" class="col-sm-3 col-form-label">Confirm New Password</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" name="confirmNewPassword" id="confirmNewPassword" required>
                    <span class="pink"><?php echo $confirmNewPasswordErr; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-9">
                    <button type="submit" name="update" class="btn btn-primary mt-3">Update</button>
                </div>
            </div>
        </form>
    </main>

    <?php include('../includes/footer.php'); ?>   
</body>
</html>