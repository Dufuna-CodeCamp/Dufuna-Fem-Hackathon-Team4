<?php
    require_once '../php_action/db_connect.php';

    // delete selected vendor
    if(isset($_POST['delete'])) {
        $id_to_delete = $_POST['id_to_delete'];
        // $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM vendors WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // success
            header('location: vendors.php');

        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    // query for all vendors
    $sql = 'SELECT * FROM vendors';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $vendors = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);

    // print_r($vendors);
?>

<?php require_once '../includes/header.php'; ?>

<a href='addvendor.php'><button> Add Vendor</button></a>

<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Vendor Name</th>
            <th>PhoneNumber</th>
            <th>Email</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($vendors as $vendor) { ?>
            <tr>
                <td><?php echo htmlspecialchars($vendor['id']); ?></td>
                <td><?php echo htmlspecialchars($vendor['vendor_name']); ?></td>
                <td><?php echo htmlspecialchars($vendor['phone_number']); ?></td>
                <td><?php echo htmlspecialchars($vendor['vendor_email']); ?></td>
                <td><?php echo htmlspecialchars($vendor['vendor_address']); ?></td>
                <td>
                    <a href="editvendor.php?id=<?php echo $vendor['id']; ?>">Edit</a>
                    <!-- DELETE FORM -->
                    <form action="vendors.php" method="POST">
                        <input type='hidden' name='id_to_delete' value="<?php echo $vendor['id']; ?>">
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    <tbody>
</table>


<?php require_once '../includes/footer.php'; ?>