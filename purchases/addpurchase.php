<?php

    require_once 'php_action/core.php';

    $valid['success'] = array('success' => false, 'messages' => array());

    // query for all vendors
    $sql = 'SELECT * FROM vendors';
    $sql_second = 'SELECT * FROM inventories';

    // make query and get result
    $result = mysqli_query($conn, $sql);
    $result_second = mysqli_query($conn, $sql_second);

    // fetch the resulting rows as an array
    $vendors = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $products = mysqli_fetch_all($result_second, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
    mysqli_free_result($result_second);

    if($_POST) {
        $productId = $_POST['productId'];
        $purchasePrice = $_POST['purchasePrice'];
        $quantityPurchased = $_POST['quantityPurchased'];
        $totalPrice = $purchasePrice * $quantityPurchased;
        $vendor = $_POST['vendor'];
        
        // assign userId to the user currently logged in
        $userId = $_SESSION['id'];

        $sql = "INSERT INTO purchases (inventory_id, purchase_price, quantity_purchased, total, vendor_id, user_id) VALUES ('$productId', '$purchasePrice', '$quantityPurchased', '$totalPrice', '$vendor', '$userId')";
    
        if($conn->query($sql) === TRUE) {
            $sqlFetch = "SELECT product_quantity, stock_status FROM inventories WHERE id=$productId";
            $fetchedResult = $conn->query($sqlFetch);
        
            if($fetchedResult->num_rows == 1) {
                $value = $fetchedResult->fetch_assoc();
                $productQuantity = $value['product_quantity'];
                $stockStatus = $value['stock_status'];
                echo $productQuantity;
                echo $stockStatus;
                $productQuantity = $productQuantity + $quantityPurchased;
                echo $productQuantity;

                if($productQuantity == 0) {
                    $stockStatus = 'out of stock';
                } elseif(($productQuantity < 10)) {
                    $stockStatus = 'low stock';
                } else {
                    $stockStatus = 'in stock';
                }

                echo $stockStatus;

                $sqlUpdate = "UPDATE inventories SET product_quantity = '$productQuantity', stock_status='$stockStatus' WHERE id = '$productId'";

                if(mysqli_query($conn, $sqlUpdate)) {
                    // success -> redirect back to the categories page
                    header('location: purchases.php');
                } {
                    // failure
                    echo 'query error: ' . mysqli_error($conn);
                }

            } else {
                $valid['success'] = false;
                $valid['messages'] = 'Error while fetching product info';
            }
            // header('location: inventories.php');
            // $valid['success'] = true;
            // $valid['messages'] = 'Successfully Added';
        } else {
            $valid['success'] = false;
            $valid['messages'] = 'Error while adding purchase';
        }

        $conn->close();

        echo json_encode($valid);
    }

?>

<?php require_once 'includes/header.php'; ?>

<form action='addpurchase.php' method='POST'>
    <label for='productId'>Product Name</label>
    <select name='productId' id='productId'>
        <?php foreach($products as $product) { ?>
            <option value='<?php echo htmlspecialchars($product['id']); ?>'>
                <?php echo htmlspecialchars($product['product_name']); ?>
            </option>
            
        <?php } ?>

    </select>
    <br /><br />
    <label for='purchasePrice'>Purchase Price</label>
    <input type='text' name='purchasePrice' id='purchasePrice' />
    <br /><br />
    <label for='quantityPurchased'>Quantity Purchased</label>
    <input type='text' name='quantityPurchased' id='quantityPurchased' />
    <br /><br />
    <label for='vendor'>Vendor</label>
    <select name='vendor' id='vendor'>
        <?php foreach($vendors as $vendor) { ?>
            <option value='<?php echo htmlspecialchars($vendor['id']); ?>'>
                <?php echo htmlspecialchars($vendor['vendor_name']); ?>
            </option>
            
        <?php } ?>

    </select>
    <br /><br />
    <button type='submit'> Submit</button>

</form>


<?php require_once 'includes/footer.php'; ?>