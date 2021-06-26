<?php
    require_once '../php_action/db_connect.php';

    // delete selected purchase
    if(isset($_POST['delete'])) {
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM purchases WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // success
            header('location: purchases.php');

        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    // query for all purchases
    $sql = 'SELECT users.username, vendors.vendor_name, inventories.product_name, purchases.quantity_purchased, purchases.purchase_price, purchases.total, purchases.id, purchases.created_at FROM (((purchases INNER JOIN inventories ON purchases.inventory_id = inventories.id) INNER JOIN users ON purchases.user_id = users.id) INNER JOIN vendors ON purchases.vendor_id = vendors.id)';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $purchases = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
  
?>

<?php require_once '../includes/header.php'; ?>
    <div class='category-header'>
        <span class='heading purchase'>
            <img src='../Images/purchases.png' alt='purchases icon' />
            <h2>Purchase Orders</h2>
        </span>
        <a href='addpurchase.php'>
            <button><i class="fa fa-plus" aria-hidden="true"></i> New Purchase</button>
        </a>
    </div>
    
    <div class='field'>
        <form class='field-form'>
            <input type='search' placeholder='Search Purchase orders' />
            <button type='submit' class='filter-btn'>Filter</button>
        </form>
    
        <table>
            <thead>
                <tr>
                    <th>Inventory</th>
                    <th>PRN</th>
                    <th>Vendor</th>
                    <th>Quantity</th>
                    <th>Cost per Inventory</th>
                    <th>Total Price</th>
                    <th>Created at</th>
                    <th>Created by</th>
                </tr>
            </thead>
    
            <tbody>
                <?php foreach($purchases as $purchase) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($purchase['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['id']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['vendor_name']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['quantity_purchased']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['purchase_price']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['total']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($purchase['username']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- 
            <p>You currently have no purchase order in your database</p> 
            <a href='addpurchase.html'>Add New Purchase Order</a>
        -->
    </div>
    
<?php require_once '../includes/footer.php'; ?>