<?php 
    session_start();
    require_once("../includes/database.php");

    function filterInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $ownerId = $_SESSION["user_id"];
    $errCount = 0;
    $name = $basePrice = $description1 = $description2 = $description3 = $description4 = $description5 = $imageName1 = $imageName2 = $imageName3 = "";
    $image1Err = $image2Err = $image3Err = $status = "";

    if(isset($_POST['submit'])) {
        $name = filterInput($_POST['name']);
        $basePrice = filterInput($_POST['price']);
        $duration = filterInput($_POST['duration']);
        $description1 = filterInput($_POST['description1']);
        $description2 = filterInput($_POST['description2']); 
        $description3 = filterInput($_POST['description3']);
        $description4 = filterInput($_POST['description4']);
        $description5 = filterInput($_POST['description5']); 
        $imageName1 = $_FILES["image1"]["name"];
        $imageName2 = $_FILES["image2"]["name"];
        $imageName3 = $_FILES["image3"]["name"];
        
        // for image handling
        $targetDir = "../uploads/";
        $temp1 = explode(".", $imageName1);
        $temp2 = explode(".", $imageName2);
        $temp3 = explode(".", $imageName3);
        $newImageName1 = round(microtime(true)) . 'a.' . end($temp1);
        $newImageName2 = round(microtime(true)) . 'b.' . end($temp2);
        $newImageName3 = round(microtime(true)) . 'c.' . end($temp3);
        $targetFile1 = $targetDir . $newImageName1;
        $targetFile2 = $targetDir . $newImageName2;
        $targetFile3 = $targetDir . $newImageName3;

        if(! $check1 = getimagesize($_FILES["image1"]["tmp_name"]) ) {
            $image1Err = "File is not an image";
            $errCount++;
        }
        if(! $check2 = getimagesize($_FILES["image2"]["tmp_name"]) ) {
            $image2Err = "File is not an image";
            $errCount++;
        }
        if(! $check3 = getimagesize($_FILES["image3"]["tmp_name"]) ) {
            $image3Err = "File is not an image";
            $errCount++;
        }

        if(! $errCount) {
            // insert operation in product table
            $query = "INSERT INTO product(product_id, product_name, duration, base_price, image1, image2, image3, description1, description2, description3, description4, description5) 
            VALUES ('', '$name', '$duration', '$basePrice', '$newImageName1', '$newImageName2', '$newImageName3', '$description1', '$description2', '$description3', '$description4', '$description5')";
            
            if(mysqli_query($db, $query)) {
                // insert operation in product_status table
                $productId = mysqli_insert_id($db);
                $productStatus = "pending";
                $query2 = "INSERT INTO product_status(product_id, user_id, status) VALUES ('$productId', '$ownerId', '$productStatus')";
                mysqli_query($db, $query2);

                $status = "<p class='alert alert-success'>Request Sent !!</p>";
                move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile1);
                move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2);
                move_uploaded_file($_FILES["image3"]["tmp_name"], $targetFile3);
                header("Refresh:1; url=user_home.php");
            }
            else {
                $status = "<p class='alert alert-warning'>Request Failed !!</p>";
                echo("Error description: " . mysqli_error($db));
            }
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
        .red {
            color: red;
        }
        .container {
            min-height: 68vh;
        }
        footer {
            text-align: center;
            background-color: lightgrey;
            padding: 20px;
            margin-top: 150px;
            text-align: center;
            width: 100%;
        }
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
            <a class="nav-item nav-link mr-3 active" href="user_request_auction.php"><i class="fas fa-satellite-dish"></i> Request Auction</a>
            <a class="nav-item nav-link mr-3" href="user_arrangement.php"><i class="fas fa-layer-group"></i> Arrangements</a>
            <a class="nav-item nav-link mr-3" href="user_participation.php"><i class="far fa-chart-bar"></i> Participations</a>
            <a class="nav-item nav-link mr-3" href="user_win.php"><i class="fas fa-trophy"></i> Wins</a>
        </div>
        <div class="navbar-nav h5">
            <a class="nav-item nav-link mr-3" href="user_profile.php"><i class="fas fa-user"></i> <?php echo $_SESSION['user_name']?></a>
            <a class="nav-item nav-link" href="<?php echo $_SERVER['PHP_SELF']."?logout=true"?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>


    <div class="container mt-5">
        <?php echo $status; ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Product Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" placeholder="Enter Product Name" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="base_price" class="col-sm-3 col-form-label">Base Price</label>
                <div class="col-sm-9">
                    <input type="number" class="form-control" id="base_price" min="0" step=".01" pattern="^\d*(\.\d{0,2})?$" name="price" value="<?php echo $basePrice; ?>" placeholder="Enter Base Price up to 2 decimal points" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Duration</label>
                <div class="row col-sm-9">
                    <div class="col-sm-3">
                        <input type="radio" name="duration" id="duration1" value="3" checked>
                        <label for="duration1">3 Days</label>
                    </div>
                    <div class="col-sm-3">
                        <input type="radio" name="duration" id="duration2" value="5">
                        <label for="duration2">5 Days</label>                    
                    </div>
                    <div class="col-sm-3">
                        <input type="radio" name="duration" id="duration3" value="7">
                        <label for="duration3">7 Days</label>                    
                    </div>
                    <div class="col-sm-3">
                        <input type="radio" name="duration" id="duration4" value="9">
                        <label for="duration4">9 Days</label>                    
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="description1" class="col-sm-3 col-form-label">Description 1</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description1" name="description1" value="<?php echo $description1; ?>" placeholder="Enter Description of Product" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description2" class="col-sm-3 col-form-label">Description 2</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description2" name="description2" value="<?php echo $description2; ?>" placeholder="Enter Description of Product" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description3" class="col-sm-3 col-form-label">Description 3</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description3" name="description3" value="<?php echo $description3; ?>" placeholder="Enter Description of Product" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description4" class="col-sm-3 col-form-label">Description 4</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description4" name="description4" value="<?php echo $description4; ?>" placeholder="Enter Description of Product" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="description5" class="col-sm-3 col-form-label">Description 5</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="description5" name="description5" value="<?php echo $description5; ?>" placeholder="Enter Description of Product" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="image1" class="col-sm-3 col-form-label">Image 1 (Display Image)</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control-file" name="image1" id="image1" required>
                    <span class="red"><?php echo $image1Err; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="image2" class="col-sm-3 col-form-label">Image 2</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control-file" name="image2" id="image2" required>
                    <span class="red"><?php echo $image2Err; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <label for="image3" class="col-sm-3 col-form-label">Image 3</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control-file" name="image3" id="image3" required>
                    <span class="red"><?php echo $image3Err; ?></span>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-9">
                    <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>  
</body>
</html>