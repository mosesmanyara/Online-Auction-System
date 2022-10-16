<?php
    session_start();
    require_once("../includes/database.php");

    $index = 1;
    $query = "SELECT * FROM user";
    $result = mysqli_query($db, $query);
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
            <a class="nav-item nav-link mr-3 active" href="admin_user_list.php"><i class="fas fa-address-book"></i> User List</a>
            <a class="nav-item nav-link mr-3" href="admin_auction_requests.php"><i class="fas fa-satellite-dish"></i> Auction Requests</a>
            <a class="nav-item nav-link mr-3" href="admin_refresh_status.php"><i class="fas fa-sync-alt"></i> Refresh Status</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="admin_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    
    <main class="container">
        <h1 class="display-4 text-center my-4">Users List</h1>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>

            <?php while($row = mysqli_fetch_array($result)) { ?>
                <tr style="cursor: pointer;" onclick="window.location='admin_single_user.php?user_id=<?php echo $row['user_id']?>'">
                    <th scope="row"><?php echo $index++; ?></th>
                    <td><?php echo $row['user_id'] ?></td>
                    <td><?php echo $row['user_name'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </main>

    <?php include('../includes/footer.php'); ?>   
</body>
</html>