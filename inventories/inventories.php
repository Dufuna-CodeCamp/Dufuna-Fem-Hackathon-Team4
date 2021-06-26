<?php
    require_once '../php_action/db_connect.php';

    // delete selected inventory
    if(isset($_POST['delete'])) {
        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM inventories WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // success
            header('location: inventories.php');

        } {
            // failure
            echo 'query error: ' . mysqli_error($conn);
        }
    }

    // query for all columns
    $sql = "SELECT users.username, users.id, inventories.product_name, categories.id, categories.category_name,
    inventories.product_quantity, inventories.stock_status, inventories.created_at, inventories.id FROM 
    ((inventories INNER JOIN categories ON inventories.category_id=categories.id) INNER JOIN users ON inventories.user_id = users.id)";

    // make query and get result
    $result = mysqli_query($conn, $sql);

    // fetch the resulting rows as an array
    $inventories [] = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // free result from memory
    mysqli_free_result($result);
?>

<?php require_once '../includes/header.php'; ?>

    <div class='category-header'>
        <span class='heading purchase'>
            <img src='../Images/inventories.png' alt='Inventory icon' />
            <h2>Inventories</h2>
        </span>
        <a href='addinventory.php'>
            <button><i class="fa fa-plus" aria-hidden="true"></i> New Inventory</button>
        </a>
    </div>
    
    <div class='field'>
        <form class='field-form'>
            <input type='search' placeholder='Search for inventory' />
            <button type='submit' class='filter-btn'>Filter</button>
        </form>
    
        <table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Inventory Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Created at</th>
                    <th>Created by</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($inventories as $inventory) { ?>
                    <tr>
                    <td><?php echo htmlspecialchars($inventory['id']); ?></td>
                    <td><?php echo htmlspecialchars($inventory['product_name']); ?></td>
                    <td><?php echo htmlspecialchars($inventory['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($inventory['product_quantity']); ?></td>
                    <td><?php echo htmlspecialchars($inventory['stock_status']); ?></td>
                    <td><?php echo htmlspecialchars($inventory['created_at']); ?></td>
                    <td><?php echo htmlspecialchars($inventory['username']); ?></td>
                        <td>
                            <button class='del-btn'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- 
            <p>You currently have no purchase order in your database</p> 
            <a href='addpurchase.html'>Add New Purchase Order</a>
        -->
    </div>

<?php require_once '../includes/footer.php'; ?>