<?php

    require_once '../php_action/core.php';

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

        echo json_encode($valid);
    }
?>

<?php require_once '../includes/header.php'; ?>

    <div class='addpurchase'>
        <span class='heading purchase'>
            <img src='../Images/purchases.png' alt='Purchase icon' />
            <h3>New Purchase Order</h3>
        </span>
        <form class='vendor-form' action='addpurchase.php' method='POST'>
            <div>
                <label for='vendor'>Vendor</label>
                <select name='vendor' id='vendor'>
                    <?php foreach($vendors as $vendor) { ?>
                        <option value='<?php echo htmlspecialchars($vendor['id']); ?>'>
                            <?php echo htmlspecialchars($vendor['vendor_name']); ?>
                        </option>
                        
                    <?php } ?>

                </select>
            </div>
            <div>
                <label for='prn'>Purchase reference no (PRN)</label>
                <input type='text' id='prn' name='prn' />
            </div>

            <div>
                <label for='purchaseNote'>Purchase Notes</label>
                <textarea id='purchaseNote' name='purchaseNote'  ></textarea>
            </div>

            <table>
                <tr>
                    <th>Product Details</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>
                    <select name='productId' id='productId'>
                        <?php foreach($products as $product) { ?>
                            <option value='<?php echo htmlspecialchars($product['id']); ?>'>
                                <?php echo htmlspecialchars($product['product_name']); ?>
                            </option>
                            
                        <?php } ?>
                    </select>
                    </td>
                    <td>
                        <input type='text' name='description' placeholder="Enter Description" />
                    </td>
                    <td>
                        <input type='number' name='quantityPurchased' id='quantityPurchased' placeholder="Enter Quantity" />
                    </td>
                    <td>
                        <input type='number' name='purchasePrice' id='purchasePrice' placeholder="Enter Cost" />
                    </td>
                    <td>
                        0.00
                    </td>
                </tr>
                <tr>
                    <td colspan="2">TOTAL</td>
                    <td>0</td>
                    <td>0.00</td>
                    <td>0.00</td>
                </tr>
            </table>
                        
            <div class='add-action-btn'>
                <button type='submit'>Save</button>
                <a href='purchases.php'>Cancel</a>
            </div>
        </form>
    </div>


<?php require_once '../includes/footer.php'; ?>