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

    // close connection
    mysqli_close($conn);

?>

<?php require_once '../includes/header.php'; ?>

<a href='addpurchase.php'><button> Add Purchase</button></a>

<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Vendor</th>
            <th>Created at</th>
            <th>Created by</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($purchases as $purchase) { ?>
            <tr>
                <td><?php echo htmlspecialchars($purchase['id']); ?></td>
                <td><?php echo htmlspecialchars($purchase['product_name']); ?></td>
                <td><?php echo htmlspecialchars($purchase['purchase_price']); ?></td>
                <td><?php echo htmlspecialchars($purchase['quantity_purchased']); ?></td>
                <td><?php echo htmlspecialchars($purchase['total']); ?></td>
                <td><?php echo htmlspecialchars($purchase['vendor_name']); ?></td>
                <td><?php echo htmlspecialchars($purchase['created_at']); ?></td>
                <td><?php echo htmlspecialchars($purchase['username']); ?></td>
            </tr>
        <?php } ?>
    <tbody>
</table>


<?php require_once '../includes/footer.php'; ?>