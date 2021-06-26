<?php 
    require_once '../php_action/core.php';
    $userId = $_SESSION['id'];
    echo $userId;
    $nameSql = "SELECT firstname, lastname FROM users WHERE id='$userId'";
    $nameResult = $conn->query($nameSql);
                
   
        $name = $nameResult->fetch_assoc();
        $firstname = $name['firstname'];
        $lastname = $name['lastname'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='../style.css' />
    <link rel='stylesheet' href='../app.css' />
    <script src="https://use.fontawesome.com/3ca8073125.js"></script>
    <title>Inventory Management Software</title>
</head>
<body>
    <header>
        <p class='title'>Inventory Management System</p>
        <div>
            <img src='../Images/avatar.png' alt='avatar icon'/>
            <p><?php echo $firstname. ' ' .$lastname; ?></p>
            <a href="../logout.php"> Log Out </a>
        </div>
    </header>
    <div class='main'>
        <nav>
            <ul>
                <li>
                    <a href='../dashboard'>
                        <img src='../Images/dashboard.png' alt='dashboard icon' />
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href='#'>
                        <img src='../Images/customers.png' alt='customers icon' />
                        <span>Customers</span>
                    </a>
                </li>
                <li>
                    <a href='../categories/categories.php'>
                        <img src='../Images/categories.png' alt='categories icon' />
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href='../inventories/inventories.php'>
                        <img src='../Images/inventories.png' alt='inventories icon' />
                        <span>Inventories</span>
                    </a>
                </li>
                <li>
                    <a href='../vendors/vendors.php'>
                        <img src='../Images/vendors.png' alt='vendors icon' />
                        Vendors
                    </a>
                </li>
                <li>
                    <a href='../purchases/purchases.php'>
                        <img src='../Images/purchases.png' alt='purchases icon' />
                        Purchases
                    </a>
                </li>
                <li>
                    <a href='../sales/sales.php'>
                        <img src='../Images/sales.png' alt='sales icon' />
                        Sales
                    </a>
                </li>
            </ul>
        </nav>
        <div class='right'>
            <!-- start of container -->
            <div class='content'>