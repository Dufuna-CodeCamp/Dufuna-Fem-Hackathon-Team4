<?php

    require_once '../php_action/core.php';

    $valid['success'] = array('success' => false, 'messages' => array());

    // query for all categories
    $sql = 'SELECT * FROM categories';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    if($_POST) {
        $productName = $_POST['productName'];
        $productQuantity = 0;
        $productCategory = $_POST['productCategory'];
        // assign userId to the user currently logged in
        $userId = $_SESSION['id'];
        

        if($productQuantity == 0) {
            $stockStatus = 'out of stock';
        } elseif(($productQuantity < 10)) {
            $stockStatus = 'low stock';
        } else {
            $stockStatus = 'in stock';
        }

        echo $stockStatus;

        $sql = "INSERT INTO inventories (product_name, category_id, product_quantity, stock_status, user_id) VALUES ('$productName', '$productCategory', '$productQuantity', '$stockStatus', '$userId')";
    
        if($conn->query($sql) === TRUE) {
            header('location: inventories.php');
            // $valid['success'] = true;
            // $valid['messages'] = 'Successfully Added';
        } else {
            $valid['success'] = false;
            $valid['messages'] = 'Error while adding vendor';
        }

        echo json_encode($valid);
    }
?>
<?php require_once '../includes/header.php'; ?>

    <div class='addpurchase'>
        <span class='heading purchase'>
            <img src='../Images/inventories.png' alt='Inventory icon' />
            <h3>New Inventory</h3>
        </span>
        <form class='vendor-form' action='addinventory.php' method='POST'>
            <div>
                <label for='productName'>Inventory Name</label>
                <input type='text' id='productName' name='productName' />
            </div>

            <div>
                <label for='quantity'>Purchase reference no (PRN)</label>
                <input type='text' id='quantity' name='quantity' />
            </div>

            <div>
                <label for='description'>Description</label>
                <textarea id='description' name='description'  ></textarea>
            </div>

            <div>
                <label for='productCategory'>Category</label>
                <select name='productCategory' id='productCategory'>
                    <?php foreach($categories as $category) { ?>
                        <option value='<?php echo htmlspecialchars($category['id']); ?>'>
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class='add-action-btn'>
                <button type='submit'>Save</button>
                <a href='inventories.html'>Cancel</a>
            </div>
        </form>
    </div>

<?php require_once '../includes/footer.php'; ?>