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
?>

<?php require_once '../includes/header.php'; ?>

    <div class='category-header'>
        <span class='heading'>
            <img src='../Images/vendors.png' alt='vendors icon' />
            <h2>Vendors</h2>
        </span>
        <a href='addvendor.php'>
            <button><i class="fa fa-plus" aria-hidden="true"></i> New Vendor</button>
        </a>
    </div>
    
    <div class='field'>
        <form class='field-form'>
            <input type='search' placeholder='Search for vendor' />
            <button type='submit' class='filter-btn'>Filter</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Vendor Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Actions</th>
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
                            <a href="editvendor.php?id=<?php echo $vendor['id']; ?>"><button>Edit <i class="fa fa-pencil" aria-hidden="true"></i></button></a>
                            <!-- DELETE FORM -->
                            <form action="vendors.php" method="POST">
                                <input type='hidden' name='id_to_delete' value="<?php echo $vendor['id']; ?>">
                                <button type='submit' name='delete' class='del-btn'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            <tbody>
                  
        </table>
    </div>

<?php require_once '../includes/footer.php'; ?>