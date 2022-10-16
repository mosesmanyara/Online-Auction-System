<?php 
    session_start();
    require_once("includes/database.php");

    function login($tableName, $db, $email, $password, $remember) {
        $query = "SELECT * FROM  $tableName WHERE email = '$email' ";
        $result = mysqli_query($db, $query);

        if(! mysqli_num_rows($result)) return false;
        $row = mysqli_fetch_array($result);
        $dbPassword = $row["password"];
        if(! password_verify($password, $dbPassword)) return false;
        
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["user_name"] = $row["user_name"];
        setcookie("email", $email, time() + (3600 * 24 * 30), "/");
        setcookie("password", $password, time() + (3600 * 24 * 30), "/");
        if($remember) setcookie("logout", 0, time() + (3600 * 24 * 30), "/");
        return true;
    }

    $email = $password = $loginErr = "";
    if(isset($_COOKIE["email"])) $email = $_COOKIE["email"];
    if(isset($_COOKIE["password"])) $password = $_COOKIE["password"];

    if(isset($_COOKIE["logout"]) && $_COOKIE["logout"] == false) {
        if(login('admin', $db, $email, $password, 1)) header("Refresh:0; url=admin/admin_home.php");
        if(login('user', $db, $email, $password, 1)) header("Refresh:0; url=user/user_home.php");
    }

    if(isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        if(isset($_POST['rememberMe'])) $remember = true;
        else $remember = false;

        if(login('admin', $db, $email, $password, $remember))("Refresh:0; url=admin/admin_home.php");
        else if(login('user', $db, $email, $password, $remember)) header("Refresh:0; url=user/user_home.php");
        else $loginErr = "Invalid email or password !! Try again";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
    <title>Auction</title>
</head>
<body>
    <img class="bg-image" src="images/judge.jpg" alt="">
    <div class="dark-overlay"></div>

    <div class="container">
        <div class="log-in">
            <img src="images/auction.png" alt=""> 
            
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input class="form-control" type="text" name="email" value="<?php echo $email; ?>" placeholder="Email" required>
                <input class="form-control" type="password" name="password" value="<?php echo $password; ?>" placeholder="Password" required>
                <div class="remember-me">
                    <input type="checkbox" name="rememberMe" value="remember" id="rememberMe">
                    <label for="rememberMe">Remember Me</label>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Sign In">
            </form>

            <?php 
                if($loginErr) {
                    echo '<div class="invalid-alert text-danger" role="alert">';
                    echo $loginErr;
                    echo '</div>';
                }
            ?>

            <p class="register">Don't have an account? <a href="register.php">Register First</a></p>
        </div>
    </div>
</body>
</html>