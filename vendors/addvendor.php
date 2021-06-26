<?php

    require_once '../php_action/core.php';

    $valid['success'] = array('success' => false, 'messages' => array());

    if($_POST) {
        $vendorName = $_POST['vendorName'];
        $vendorPhoneNumber = $_POST['vendorPhoneNumber'];
        $vendorEmail = $_POST['vendorEmail'];
        $vendorAddress = $_POST['vendorAddress'];
        $country = $_POST['country'];
        $state =  $_POST['state'];
        $city =  $_POST['city'];
        $vendorAddress = "'$streetAddress' .', ' . '$city' .', ' .'$state' .', ' .'$country'";
        $sql = "INSERT INTO vendors (vendor_name, phone_number, vendor_email, vendor_address)
        VALUES ('$vendorName', '$vendorPhoneNumber', '$vendorEmail', '$vendorAddress')";
    
        if($conn->query($sql) === TRUE) {
            header('location: vendors.php');
            // $valid['success'] = true;
            // $valid['messages'] = 'Successfully Added';
        } else {
            $valid['success'] = false;
            $valid['messages'] = 'Error while adding vendor';
        }

   
        echo json_encode($valid);
    }
?>

<?php require_once '../includes/header.php'; ?>

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
                <label for='vendorAddress'>Vendor Address</label>
                <input type='text' name='streetAddress' id='streetAddress' />
            </div>
            
            <div class='add-action-btn'>
                <button type='submit'>Save</button>
                <a href='vendors.php'>Cancel</a>
            </div>
        </form>
    </div>

<?php require_once '../includes/footer.php'; ?>