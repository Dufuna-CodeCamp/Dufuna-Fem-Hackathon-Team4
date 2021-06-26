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
    $sql = 'SELECT users.email, users.id, categories.description, categories.category_name, 
    categories.created_at, categories.id FROM users, categories WHERE categories.user_id=users.id';

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
?>

<?php require_once '../includes/header.php'; ?>

    <div class='category-header'>
        <span class='heading'>
            <img src='../Images/categories.png' alt='categories icon' />
            <h2>Categories</h2>
        </span>
        <a href='addcategory.php'>
            <button><i class="fa fa-plus" aria-hidden="true"></i> New Category</button>
        </a>
    </div>    
    <div class='field'>
        <form class='field-form'>
            <input type='search' placeholder='Search for category' />
            <button type='submit' class='filter-btn'>Filter</button>
        </form>
    
        <table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Category Name</th>
                    <th>Created at</th>
                    <th>Created by</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
    
            <tbody>
                <?php foreach($categories as $category) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category['id']); ?></td>
                        <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($category['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($category['email']); ?></td>
                        <td><?php echo htmlspecialchars($category['description']); ?></td>
                        <td>
                            <a href="editcategory.php?id=<?php echo $category['id']; ?>">
                                <button>Edit <i class="fa fa-pencil" aria-hidden="true"></i></button>
                            </a>
                            <!-- DELETE FORM -->
                            <form action="categories.php" method="POST">
                                <input type='hidden' name='id_to_delete' value="<?php echo $category['id']; ?>">
                                <button class='del-btn' type='submit' name='delete'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php require_once '../includes/footer.php'; ?>