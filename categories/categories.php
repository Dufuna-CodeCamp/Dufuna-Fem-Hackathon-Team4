<?php
    require_once '../php_action/db_connect.php';

    // delete selected category
    if(isset($_POST['delete'])) {
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM categories WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // success
            header('location: categories.php');

        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    // query for all categories
    $sql = 'SELECT users.username, users.id, categories.description, categories.category_name, categories.created_at, categories.id FROM users, categories WHERE categories.user_id=users.id';


    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);

    // close connection
    mysqli_close($conn);

?>

<?php require_once '../includes/header.php'; ?>

<a href='addcategory.php'><button> Add Category</button></a>

<table>
    <thead>
        <tr>
            <th>S/N</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Created at</th>
            <th>Created by</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($categories as $category) { ?>
            <tr>
                <td><?php echo htmlspecialchars($category['id']); ?></td>
                <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                <td><?php echo htmlspecialchars($category['description']); ?></td>
                <td><?php echo htmlspecialchars($category['created_at']); ?></td>
                <td><?php echo htmlspecialchars($category['username']); ?></td>
                <td>
                    <a href="editcategory.php?id=<?php echo $category['id']; ?>">Edit</a>
                    <!-- DELETE FORM -->
                    <form action="categories.php" method="POST">
                        <input type='hidden' name='id_to_delete' value="<?php echo $category['id']; ?>">
                        <button type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    <tbody>
</table>


<?php require_once '../includes/footer.php'; ?>