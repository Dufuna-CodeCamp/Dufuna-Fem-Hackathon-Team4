<?php
    require_once 'php_action/db_connect.php';

    // edit selected record
    if($_POST) {
        $categoryName = $_POST['categoryName'];
        $categoryDescription = $_POST['categoryDescription'];
        $categoryId = $_POST['categoryId'];
    
        $sql = "UPDATE categories SET category_name = '$categoryName', description = '$categoryDescription' WHERE id = '$categoryId'";

        if(mysqli_query($conn, $sql)) {
            // success -> redirect back to the categories page
            header('location: categories.php');
        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

   
    // check GET request id param
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        // make sql
        $sql = "SELECT * FROM categories WHERE id = $id";

        // get the query result
        $result = mysqli_query($conn, $sql);

        // fetch result in array format
        $category = mysqli_fetch_assoc($result);

        // free result from memory
        mysqli_free_result($result);

        // close connection
        mysqli_close($conn);

        // print_r($vendor);

    }

?>

<?php require_once 'includes/header.php'; ?>

    <?php if($category): ?>

        <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
            <label for='categoryName'>Category Name</label>
            <input type='text' name='categoryName' id='categoryName' value=<?php echo htmlspecialchars($category['category_name']); ?> />
            <br /><br />
            <label for='categoryDescription'>Category Description </label>
            <input type='text' name='categoryDescription' id='categoryDescription' value=<?php echo $category['description']; ?> />
            <br /><br />
            <input type='hidden' name='categoryId' value=<?php echo htmlspecialchars($category['id']); ?> />
            <button type='submit' name='edit'> Save Changes</button>
        </form>
    
    <?php else: ?>
        
        <h2>Oops!! There is no vendor with this id</h2>

    <?php endif; ?>



<?php require_once 'includes/footer.php'; ?>