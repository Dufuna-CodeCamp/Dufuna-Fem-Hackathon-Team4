<?php

    require_once 'php_action/core.php';

    $valid['success'] = array('success' => false, 'messages' => array());

    if($_POST) {
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'];
        // assign userId to the user currently logged in
        $userId = $_SESSION['id'];

        $sql = "INSERT INTO categories (category_name, description, user_id) VALUES ('$categoryName', '$categoryDescription', '$userId')";
    
        if($conn->query($sql) === TRUE) {
            header('location: categories.php');
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

<form action='addcategory.php' method='POST'>
    <label for='categoryName'>Category Name</label>
    <input type='text' name='categoryName' id='categoryName' />
    <br /><br />
    <label for='categoryDescription'>categoryDescription</label>
    <input type='text' name='categoryDescription' id='categoryDescription' />
    <br /><br />
    <button type='submit'> Submit</button>

</form>


<?php require_once 'includes/footer.php'; ?>