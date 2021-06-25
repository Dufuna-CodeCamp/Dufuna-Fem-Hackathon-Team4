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

<form action='addvendor.php' method='POST'>
    <label for='vendorName'>Vendor Name</label>
    <input type='text' name='vendorName' id='vendorName' />
    <br /><br />
    <label for='vendorPhoneNumber'>Vendor Phone Number</label>
    <input type='text' name='vendorPhoneNumber' id='vendorPhoneNumber' />
    <br /><br />
    <label for='vendorEmail'>Vendor Email</label>
    <input type='email' name='vendorEmail' id='vendorEmail' />
    <br /><br />
    <label for='vendorAddress'>Vendor Address</label>
    <input type='text' name='vendorAddress' id='vendorAddress' />
    <br /><br />
    <button type='submit'> Submit</button>

</form>


<?php require_once 'includes/footer.php'; ?>