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
        $salesPrice = $_POST['salesPrice'];
        $quantitySold = $_POST['quantitySold'];
        $totalPrice = $salesPrice * $quantitySold;
        $customerName = $_POST['customerName'];

        // $vendor = $_POST['vendor'];
        
        // assign userId to the user currently logged in
        $userId = $_SESSION['id'];

        $sql = "INSERT INTO sales (inventory_id, sales_price, quantity_sold, total, customer_name, user_id) VALUES ('$productId', '$salesPrice', '$quantitySold', '$totalPrice', '$customerName', '$userId')";
    
        if($conn->query($sql) === TRUE) {
            $sqlFetch = "SELECT product_quantity, stock_status FROM inventories WHERE id=$productId";
            $fetchedResult = $conn->query($sqlFetch);
        
            if($fetchedResult->num_rows == 1) {
                $value = $fetchedResult->fetch_assoc();
                $productQuantity = $value['product_quantity'];
                $stockStatus = $value['stock_status'];
                echo $productQuantity;
                echo $stockStatus;

                if($productQuantity < $quantitySold) {

                    $valid['success'] = false;
                    $valid['messages'] = "You don't have enough products";

                } else {

                    $productQuantity = $productQuantity - $quantitySold;
                    echo $productQuantity;

                    if($productQuantity == 0) {
                        $stockStatus = 'out of stock';

                    } elseif(($productQuantity < 10)) {
                        $stockStatus = 'low stock';

                    } else {
                        $stockStatus = 'in stock';
                        echo $stockStatus;
        
                        $sqlUpdate = "UPDATE inventories SET product_quantity = '$productQuantity', stock_status='$stockStatus' WHERE id = '$productId'";
        
                        if(mysqli_query($conn, $sqlUpdate)) {
                            // success -> redirect back to the categories page
                            header('location: sales.php');
                        } {
                            // failure
                            echo 'query error: ' . mysqli_error($conn);
                        }
                    }
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
            $valid['messages'] = 'Error while adding sales';
        }

        echo json_encode($valid);
    }
?>

<?php require_once '../includes/header.php'; ?>

    <div class='addpurchase'>
        <span class='heading purchase'>
            <img src='../Images/sales.png' alt='Sales icon' />
            <h3>New Sales Order</h3>
        </span>
        <form class='vendor-form' action='addsale.php' method='POST'>
            <div>
                <label for='customerName'>Customer Name</label>
                <input type='text' id='customerName' name='customerName' />
            </div>

            <div>
                <label for='srn'>Sales reference no (SRN)</label>
                <input type='text' id='srn' name='srn' />
            </div>

            <div>
                <label for='customerNote'>Customer Notes</label>
                <textarea id='customerNote' name='customerNote'  ></textarea>
            </div>

            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Cost</th>
                    <th>Amount</th>
                </tr>
                <tr>
                    <td>
                        <select name='productId' id='productId'>
                            <option default>Select item</option>
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
                        <input type='number' name='quantitySold' id='quantitySold' placeholder="Enter Quantity" />
                    </td>
                    <td>
                        <input type='number' name='salesPrice' id='salesPrice' placeholder="Enter Cost" />
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
                <a href='sales.php'>Cancel</a>
            </div>
        </form>
    </div>

</form>
<?php require_once '../includes/footer.php'; ?>