<?php
    require_once '../php_action/db_connect.php';

    // delete selected purchase
    if(isset($_POST['delete'])) {
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM purchases WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // success
            header('location: sales.php');

        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    // query for all purchases
    $sql = 'SELECT users.username, inventories.product_name, sales.quantity_sold, sales.sales_price, sales.total, sales.id, sales.created_at, sales.customer_name FROM ((sales INNER JOIN inventories ON sales.inventory_id = inventories.id) INNER JOIN users ON sales.user_id = users.id)';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $sales []= mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
    
?>

<?php require_once '../includes/header.php'; ?>

    <div class='category-header'>
        <span class='heading purchase'>
            <img src='../Images/sales.png' alt='Sales icon' />
            <h2>Sales Orders</h2>
        </span>
        <a href='addsale.php'>
            <button><i class="fa fa-plus" aria-hidden="true"></i> New Sales Order</button>
        </a>
    </div>
    
    <div class='field'>
        <form class='field-form'>
            <input type='search' placeholder='Search Sales orders' />
            <button type='submit' class='filter-btn'>Filter</button>
        </form>
    
        <table>
            <thead>
                <tr>
                    <th>SRN</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Price per item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Created at</th>
                    <th>Created by</th>
                    <th>Action</th>
                </tr>
            </thead>
    
            <tbody>
                <?php foreach($sales as $sale) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($sale['id']); ?></td>
                        <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                        <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($sale['sales_price']); ?></td>
                        <td><?php echo htmlspecialchars($sale['quantity_sold']); ?></td>
                        <td><?php echo htmlspecialchars($sale['total']); ?></td>
                        <td><?php echo htmlspecialchars($sale['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($sale['username']); ?></td>
                        <td>
                            <button class='del-btn'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            <tbody>
        </table>
        <!-- 
            <p>You currently have no sales order in your database</p> 
            <a href='addpurchase.html'>Add New Sales Order</a>
        -->

    </div>
 
<?php require_once '../includes/footer.php'; ?>