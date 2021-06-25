<?php

    require_once 'php_action/core.php';

    $valid['success'] = array('success' => false, 'messages' => array());

    if($_POST) {
        $vendorName = $_POST['vendorName'];
        $vendorPhoneNumber = $_POST['vendorPhoneNumber'];
        $vendorEmail = $_POST['vendorEmail'];
        $vendorAddress = $_POST['vendorAddress'];

        $sql = "INSERT INTO vendors (vendor_name, phone_number, vendor_email, vendor_address) VALUES ('$vendorName', '$vendorPhoneNumber', '$vendorEmail', '$vendorAddress')";
    
        if($conn->query($sql) === TRUE) {
            header('location: vendors.php');
            // $valid['success'] = true;
            // $valid['messages'] = 'Successfully Added';
        } else {
            $valid['success'] = false;
            $valid['messages'] = 'Error while adding vendor';
        }

        $conn->close();

        echo json_encode($valid);
    }

?>

<?php require_once 'includes/header.php'; ?>

    <div class='addvendor'>
        <span class='heading'>
            <img src='../Images/vendors.png' alt='vendors icon' />
            <h3> Create New Vendor</h3>
        </span>
        <form class='vendor-form' action='addvendor.php' method='POST'>
            <div>
                <label for='vendorName'>Vendor Name</label>
                <input type='text' id='vendorName' name='vendorName' />
            </div>

            <div>
                <label for='vendorPhoneNumber'>Phone Number</label>
                <input type='text' name='vendorPhoneNumber' id='vendorPhoneNumber' />
            </div>

            <div>
                <label for='vendorEmail'>Email</label>
                <input type='email' name='vendorEmail' id='vendorEmail' />
            </div>

            <div>
                <label for='website'>Website</label>
                <input type='text' id='website' name='website' />
            </div>

            <div>
                <label for='vendorAddress'>Address</label>
                <input type='text' name='vendorAddress' id='vendorAddress' />
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

            <div class='add-action-btn'>
                <button type='submit'>Save</button>
                <a href='vendors.php'>Cancel</a>
            </div>
        </form>
    </div>



<?php require_once 'includes/footer.php'; ?>