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
    $sales = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);

?>

<?php require_once '../includes/header.php'; ?>

<a href='addsales.php'><button> Add Sales</button></a>

<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Customer Name</th>
            <th>Created at</th>
            <th>Created by</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sales as $sale) { ?>
            <tr>
                <td><?php echo htmlspecialchars($sale['id']); ?></td>
                <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                <td><?php echo htmlspecialchars($sale['sales_price']); ?></td>
                <td><?php echo htmlspecialchars($sale['quantity_sold']); ?></td>
                <td><?php echo htmlspecialchars($sale['total']); ?></td>
                <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                <td><?php echo htmlspecialchars($sale['created_at']); ?></td>
                <td><?php echo htmlspecialchars($sale['username']); ?></td>
            </tr>
        <?php } ?>
    <tbody>
</table>


<?php require_once '../includes/footer.php'; ?>