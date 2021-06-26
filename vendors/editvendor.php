<?php
    require_once '../php_action/db_connect.php';

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

<?php require_once '../includes/header.php'; ?>

    <div class='addvendor'>
        <span class='heading'>
            <img src='../Images/vendors.png' alt='vendors icon' />
            <h3> Edit Vendor Details</h3>
        </span>
        <?php if($vendor): ?>
            <form class='vendor-form' action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
                <div>
                    <label for='vendorName'>Vendor Name</label>
                    <input type='text' id='vendorName' name='vendorName' value=<?php echo htmlspecialchars($vendor['vendor_name']); ?> />
                </div>

                <div>
                    <label for='vendorPhoneNumber'>Phone Number</label>
                    <input type='text' name='vendorPhoneNumber' id='vendorPhoneNumber' value=<?php echo htmlspecialchars($vendor['phone_number']); ?> />
                </div>

                <div>
                    <label for='vendorEmail'>Email</label>
                    <input type='email' name='vendorEmail' id='vendorEmail' value=<?php echo htmlspecialchars($vendor['vendor_email']); ?> />
                </div>

                <div>
                    <label for='website'>Website</label>
                    <input type='text' id='website' name='website' />
                </div>

                <div>
                    <label for='vendorAddress'>Address</label>
                    <textarea name='vendorAddress' id='vendorAddress' value=<?php echo htmlspecialchars($vendor['vendor_address']); ?> ></textarea>
                </div>

                <div class='stack'>
                    <label for='country'>Country</label>
                    <input type='text' id='country' name='country' />
                </div>

                <div class='stack'>
                    <label for='state'>State</label>
                    <input type='text' id='state' name='state' />
                </div>

                <div class='stack'>
                    <label for='city'>City</label>
                    <input type='text' id='city' name='city' />
                </div>

                <div class='stack'>
                    <label for='postal code'>Postal code</label>
                    <input type='text' id='postal code' name='postal code' />
                </div>

                <div>
                    <label for='currency'>Accepted Currency</label>
                    <input type='text' id='currency' name='currency' />
                </div>

                <div>
                    <label for='remarks'>Remarks</label>
                    <textarea id='remarks' name='remarks'  ></textarea>
                </div>

                <input type='hidden' name='vendorId' value=<?php echo htmlspecialchars($vendor['id']); ?> />

                <div class='add-action-btn'>
                    <button type='submit'>Save</button>
                    <a href='vendors.php'>Cancel</a>
                </div>
            </form>

        <?php else: ?>
        
            <h2>Oops!! There is no vendor with this id</h2>

        <?php endif; ?>

    </div>
    

<?php require_once '../includes/footer.php'; ?>