<?php
    require_once '../php_action/db_connect.php';

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
    }
?>

<?php require_once '../includes/header.php'; ?>
    <div class='addcategory'>
        <h3> Edit Category</h3>
        <?php if($category): ?>
            <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
                <div>
                    <label for='categoryName'>New Category Name</label>
                    <input type='text' id='categoryName' name='categoryName' value=<?php echo htmlspecialchars($category['category_name']); ?> />
                </div>
                <div>
                    <label for='categoryDescription'>Description</label>
                    <textarea id='categoryDescription' name='categoryDescription'  value=<?php echo $category['description']; ?>></textarea>
                </div>
                <input type='hidden' name='categoryId' value=<?php echo htmlspecialchars($category['id']); ?> />
                <div class='add-action-btn'>
                    <button type='submit'>Save</button>
                    <a href='categories.php'>Cancel</a>
                </div>
            </form>
        <?php else: ?>
            <h2>Oops!! There is no vendor with this id</h2>

        <?php endif; ?>
    </div>

<?php require_once '../includes/footer.php'; ?>
