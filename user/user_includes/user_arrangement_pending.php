<?php
    $userId = $_SESSION['user_id'];
    $query = "SELECT * FROM product NATURAL JOIN product_status WHERE status='pending' AND user_id='$userId' ";
    $result = mysqli_query($db, $query);
    
    $count = 0;
?>

<div class="product-deck">
    <?php 
    While($row = mysqli_fetch_array($result)) {
        $productId = $row['product_id'];
        $basePrice = $row['base_price'];
        $image = "../uploads/" . $row["image1"];

        if(isset($_POST['filter'])) {
            $minPrice = $_POST['min-price'];
            $maxPrice = $_POST['max-price'];
            if($basePrice < $minPrice || $basePrice > $maxPrice) continue;
        }
        $count++;
    ?>
        <div class="product">
            <div class="text-center">
                <img src="<?php echo $image ?>" alt="">
            </div>
            <h4><?php echo $row['product_name'] ?></h4>
            <h6>Base Price: $<?php echo $basePrice ?></h6>
            <button class="btn btn-block btn-primary mt-4" 
                onclick="window.location='user_single_product/user_single_product_arrangement_pending.php?productId=<?php echo $productId?>'">
                Explore
            </button>
        </div>
        <?php }

        if(! $count) echo "<p>No Result to show</p>";
        ?>   
</div>  