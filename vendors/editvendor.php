<?php
    require_once 'php_action/db_connect.php';

    // edit selected record
    if($_POST) {
        $vendorName = $_POST['vendorName'];
        $vendorPhoneNumber = $_POST['vendorPhoneNumber'];
        $vendorEmail = $_POST['vendorEmail'];
        $vendorAddress = $_POST['vendorAddress'];
        $vendorId = $_POST['vendorId'];

        $sql = "UPDATE vendors SET vendor_name = '$vendorName', phone_number = '$vendorPhoneNumber', vendor_email = '$vendorEmail', vendor_address = '$vendorAddress' WHERE id = '$vendorId'";

        if(mysqli_query($conn, $sql)) {
            // success
            header('location: vendors.php');
        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

   
    // check GET request id param
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        // make sql
        $sql = "SELECT * FROM vendors WHERE id = $id";

        // get the query result
        $result = mysqli_query($conn, $sql);

        // fetch result in array format
        $vendor = mysqli_fetch_assoc($result);

        // free result from memory
        mysqli_free_result($result);

        // close connection
        mysqli_close($conn);

        // print_r($vendor);

    }

?>

<?php require_once 'includes/header.php'; ?>

    <?php if($vendor): ?>

        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
            <label for='vendorName'>Vendor Name</label>
            <input type='text' name='vendorName' id='vendorName' value=<?php echo htmlspecialchars($vendor['vendor_name']); ?> />
            <br /><br />
            <label for='vendorPhoneNumber'>Vendor Phone Number</label>
            <input type='text' name='vendorPhoneNumber' id='vendorPhoneNumber' value=<?php echo htmlspecialchars($vendor['phone_number']); ?> />
            <br /><br />
            <label for='vendorEmail'>Vendor Email</label>
            <input type='email' name='vendorEmail' id='vendorEmail' value=<?php echo htmlspecialchars($vendor['vendor_email']); ?> />
            <br /><br />
            <label for='vendorAddress'>Vendor Address</label>
            <input type='text' name='vendorAddress' id='vendorAddress' value=<?php echo htmlspecialchars($vendor['vendor_address']); ?> />
            <br /><br />
            <input type='hidden' name='vendorId' value=<?php echo htmlspecialchars($vendor['id']); ?> />
            <button type='submit' name='edit'> Save Changes</button>
        </form>
    
    <?php else: ?>
        
        <h2>Oops!! There is no vendor with this id</h2>

    <?php endif; ?>



<?php require_once 'includes/footer.php'; ?>