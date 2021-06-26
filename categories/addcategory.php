<?php

    require_once '../php_action/core.php';

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
   
        echo json_encode($valid);
    }

?>

<?php require_once '../includes/header.php'; ?>
    <div class='addcategory'>
        <h3> New Category</h3>
        <form action='addcategory.php' method='POST'>
            <div>
                <label for='categoryName'>New Category Name</label>
                <input type='text' id='categoryName' name='categoryName' />
            </div>

            <div>
                <label for='categoryDescription'>Description</label>
                <textarea id='categoryDescription' name='categoryDescription'  ></textarea>
            </div>

            <div class='add-action-btn'>
                <button type='submit'>Save</button>
                <a href='categories.php'>Cancel</a>
            </div>
        </form>
    </div>


<?php require_once '../includes/footer.php'; ?>
