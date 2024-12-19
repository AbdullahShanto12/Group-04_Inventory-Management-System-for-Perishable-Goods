<?php
// Start session
session_start();

// Include the database connection file
include 'connect.php';




// Use session data
$email = $_SESSION['email'] ?? null;
$role = $_SESSION['role'] ?? null;




// Initialize variables for error-free rendering
$newOrdersCount = ['count' => 0];
$userRegistrationsCount = ['count' => 0];
$employeesCount = ['count' => 0];
$warehouseCount = ['count' => 0];
$lastOrder = null;




// Fetch dashboard data
$newOrdersCount = $conn->query("SELECT COUNT(*) AS count FROM orders ")->fetch_assoc();
$userRegistrationsCount = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc();
$employeesCount = $conn->query("SELECT COUNT(*) AS count FROM employees")->fetch_assoc();
$warehouseCount = $conn->query("SELECT COUNT(*) AS count FROM warehouses")->fetch_assoc();







// Fetch the most recent order (live)
$lastOrderQuery = $conn->query("
    SELECT order_id, customer_name, status, order_date, total_amount 
    FROM orders 
    ORDER BY order_date DESC, order_id DESC 
    LIMIT 1
");
$lastOrder = $lastOrderQuery ? $lastOrderQuery->fetch_assoc() : null;




// Fetch the most recent alert (live)
$lastAlertQuery = $conn->query("
    SELECT alert_id, alert_type, description, alert_date, status
    FROM alerts
    ORDER BY alert_date DESC, alert_id DESC
    LIMIT 1
");
$lastAlert = $lastAlertQuery ? $lastAlertQuery->fetch_assoc() : null;



// Fetch the most recent storage (live)
$lastStorageQuery = $conn->query("
    SELECT storage_id, storage_name, capacity, used_capacity
    FROM storage
    ORDER BY storage_id DESC
    LIMIT 1
");
$lastStorage = $lastStorageQuery ? $lastStorageQuery->fetch_assoc() : null;


// Fetch the most recent product (live)
$lastProductQuery = $conn->query("
    SELECT product_id, product_name, category, stock_quantity, price
    FROM products
    ORDER BY product_id DESC
    LIMIT 1
");
$lastProduct = $lastProductQuery ? $lastProductQuery->fetch_assoc() : null;










// Fetch all sales grouped by month names
$monthlySales = $conn->query("
    SELECT MONTHNAME(order_date) AS month_name, 
           SUM(total_amount) AS sales 
    FROM orders 
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
")->fetch_all(MYSQLI_ASSOC);



// Fetch all sales grouped by day names
$dailySales = $conn->query("
    SELECT DAYNAME(order_date) AS day_name, 
           SUM(total_amount) AS sales 
    FROM orders 
    GROUP BY DAYOFWEEK(order_date)
    ORDER BY DAYOFWEEK(order_date)
")->fetch_all(MYSQLI_ASSOC);





// Fetch weekly sales data (grouped by week)
$weeklySales = $conn->query("
    SELECT CONCAT('Week ', WEEK(order_date)) AS week_name, 
           SUM(total_amount) AS total_amount 
    FROM orders 
    GROUP BY WEEK(order_date)
    ORDER BY WEEK(order_date)
")->fetch_all(MYSQLI_ASSOC);

// Fetch monthly sales data (grouped by month)
$monthlySalesTotal = $conn->query("
    SELECT MONTHNAME(order_date) AS month_name, 
           SUM(total_amount) AS total_amount 
    FROM orders 
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
")->fetch_all(MYSQLI_ASSOC);











?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Chart.js (for generating charts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="dashboard.css">

</head>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>

 
        </ul>
    </nav>
    <!-- /.navbar -->

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Inventory System</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="orders.php" class="nav-link">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>Sales Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="Customer_Order.php" class="nav-link ">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Customer Order</p>
                        </a>
                    </li>

                        <li class="nav-item">
                            <a href="products.php" class="nav-link">
                                <i class="nav-icon fas fa-box"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="warehouses.php" class="nav-link">
                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Warehouses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="employees.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="alerts.php" class="nav-link">
                                <i class="nav-icon fas fa-exclamation-triangle"></i>
                                <p>Alerts</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="storage.php" class="nav-link ">
                                <i class="nav-icon fas fa-thermometer-half"></i>
                                <p>Storage Monitoring</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="login.html" class="nav-link">
                                <i class="nav-icon fas fa-sign-in-alt"></i>
                                <p>Log Out</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

<!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Dashboard Section -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Orders</h5>
                                <p class="card-text" id="newOrdersCount"><?php echo $newOrdersCount['count']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Warehouse </h5>
                                    <p class="card-text" id="warehouseCount"><?php echo $warehouseCount['count']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total User </h5>
                                <p class="card-text" id="userRegistrationsCount"><?php echo $userRegistrationsCount['count']; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-danger mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Total Employees </h5>
                                <p class="card-text" id="employeesCount"><?php echo $employeesCount['count']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>



                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h3 class="chart-title">Daily Sales</h3>
                                <canvas id="dailySalesChart"></canvas>
                                <h3 class="chart-title">Weekly Sales Summary</h3>
                                <canvas id="weeklySalesPieChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h3 class="chart-title">Monthly Sales</h3>
                                <canvas id="monthlySalesChart"></canvas>
                                <h3 class="chart-title">Monthly Sales Summary</h3>
                                <canvas id="monthlySalesPieChart"></canvas>
                            </div>
                        </div>





<!-- Container for the Card Sections -->
<div class="row">

<!-- Enhanced Last Order Section -->
<div class="col-md-6">
    <div class="card">
        <h3>Last Order</h3>
        <?php if ($lastOrder): ?>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($lastOrder['order_id']) ?></p>
            <p><strong>Customer Name:</strong> <?= htmlspecialchars($lastOrder['customer_name']) ?></p>
            <p><strong>Status:</strong> 
                <?php if ($lastOrder['status'] === 'Pending'): ?>
                    <span style="color: orange;"><?= htmlspecialchars($lastOrder['status']) ?></span>
                <?php elseif ($lastOrder['status'] === 'Completed'): ?>
                    <span style="color: green;"><?= htmlspecialchars($lastOrder['status']) ?></span>
                <?php elseif ($lastOrder['status'] === 'Cancelled'): ?>
                    <span style="color: red;"><?= htmlspecialchars($lastOrder['status']) ?></span>
                <?php else: ?>
                    <?= htmlspecialchars($lastOrder['status']) ?>
                <?php endif; ?>
            </p>
            <p><strong>Date:</strong> <?= htmlspecialchars(date('F j, Y', strtotime($lastOrder['order_date']))) ?></p>
            <p><strong>Total Amount:</strong> $<?= htmlspecialchars(number_format($lastOrder['total_amount'], 2)) ?></p>
            <p><strong>Order Summary:</strong> 
                <?= $lastOrder['status'] === 'Completed' 
                    ? 'This order has been successfully fulfilled.' 
                    : 'Pending actions for this order.'; ?>
            </p>
        <?php else: ?>
            <p>No recent orders found.</p>
        <?php endif; ?>
    </div>
</div>

    <!-- Enhanced Most Recent Product Section -->
    <div class="col-md-6">
        <div class="card">
            <h3>Last Product</h3>
            <?php if ($lastProduct): ?>
                <p><strong>Product ID:</strong> <?= $lastProduct['product_id'] ?></p>
                <p><strong>Name:</strong> <?= $lastProduct['product_name'] ?></p>
                <p><strong>Category:</strong> <?= $lastProduct['category'] ?></p>
                <p><strong>Stock Quantity:</strong> <?= $lastProduct['stock_quantity'] ?></p>
                <p><strong>Price:</strong> $<?= number_format($lastProduct['price'], 2) ?></p>
                <p><strong>Total Stock Value:</strong> $<?= number_format($lastProduct['stock_quantity'] * $lastProduct['price'], 2) ?></p>
            <?php else: ?>
                <p>No product details found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Another Row for the Last Alert and Last Storage Sections -->
<div class="row">
    <!-- Enhanced Last Alert Section -->
    <div class="col-md-6">
        <div class="card">
            <h3>Last Alert</h3>
            <?php if ($lastAlert): ?>
                <p><strong>Alert ID:</strong> <?= $lastAlert['alert_id'] ?></p>
                <p><strong>Type:</strong> <?= $lastAlert['alert_type'] ?></p>
                <p><strong>Description:</strong> <?= $lastAlert['description'] ?></p>
                <p><strong>Date:</strong> <?= date('F j, Y', strtotime($lastAlert['alert_date'])) ?></p>
                <p><strong>Status:</strong> 
                    <?php if ($lastAlert['status'] === 'Active'): ?>
                        <span style="color: orange;"><?= $lastAlert['status'] ?> (Action Required)</span>
                    <?php elseif ($lastAlert['status'] === 'Resolved'): ?>
                        <span style="color: green;"><?= $lastAlert['status'] ?></span>
                    <?php elseif ($lastAlert['status'] === 'Closed'): ?>
                        <span style="color: gray;"><?= $lastAlert['status'] ?></span>
                    <?php else: ?>
                        <?= $lastAlert['status'] ?>
                    <?php endif; ?>
                </p>
                <p><strong>Alert Summary:</strong> 
                    <?= $lastAlert['status'] === 'Active' ? 'This alert needs immediate attention!' : 'No further action needed.'; ?>
                </p>
            <?php else: ?>
                <p>No recent alerts found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Enhanced Most Recent Storage Section -->
    <div class="col-md-6">
        <div class="card">
            <h3>Last Storage</h3>
            <?php if ($lastStorage): ?>
                <p><strong>Storage ID:</strong> <?= $lastStorage['storage_id'] ?></p>
                <p><strong>Name:</strong> <?= $lastStorage['storage_name'] ?></p>
                <p><strong>Capacity:</strong> <?= $lastStorage['capacity'] ?> units</p>
                <p><strong>Used Capacity:</strong> <?= $lastStorage['used_capacity'] ?> units</p>
                <p><strong>Usage Percentage:</strong> <?= round(($lastStorage['used_capacity'] / $lastStorage['capacity']) * 100, 2) ?>%</p>
            <?php else: ?>
                <p>No storage details found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>




        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
            All rights reserved.
        </footer>
        </div>






<!-- JS includes -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>









<script>




        // Daily Sales Chart
        const dailySalesData = <?= json_encode($dailySales); ?>;
        const dailyCtx = document.getElementById("dailySalesChart").getContext("2d");
        if (dailySalesData.length > 0) {
            new Chart(dailyCtx, {
                type: "bar",
                data: {
                    labels: dailySalesData.map(s => s.day_name),
                    datasets: [{
                        label: "Daily Sales",
                        data: dailySalesData.map(s => s.sales),
                        backgroundColor: "rgba(54, 162, 235, 0.5)",
                        borderColor: "rgba(54, 162, 235, 1)",
                    }]
                }
            });
        }



        // Monthly Sales Chart
        const monthlySalesData = <?= json_encode($monthlySales); ?>;
        const monthlyCtx = document.getElementById("monthlySalesChart").getContext("2d");
        if (monthlySalesData.length > 0) {
            new Chart(monthlyCtx, {
                type: "line",
                data: {
                    labels: monthlySalesData.map(s => s.month_name),
                    datasets: [{
                        label: "Monthly Sales",
                        data: monthlySalesData.map(s => s.sales),
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)"
                    }]
                }
            });
        }




        // Weekly Sales Pie Chart
        const weeklySalesData = <?= json_encode($weeklySales); ?>;
        const weeklyPieCtx = document.getElementById("weeklySalesPieChart").getContext("2d");
        if (weeklySalesData.length > 0) {
            new Chart(weeklyPieCtx, {
                type: "pie",
                data: {
                    labels: weeklySalesData.map(w => w.week_name),
                    datasets: [{
                        label: "Weekly Sales",
                        data: weeklySalesData.map(w => w.total_amount),
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.5)",
                            "rgba(54, 162, 235, 0.5)",
                            "rgba(75, 192, 192, 0.5)",
                            "rgba(255, 206, 86, 0.5)",
                            "rgba(153, 102, 255, 0.5)",
                            "rgba(255, 159, 64, 0.5)"
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)"
                        ],
                        borderWidth: 1
                    }]
                }
            });
        }




        // Monthly Sales Pie Chart
        const monthlySalesPieData = <?= json_encode($monthlySalesTotal); ?>;
        const monthlyPieCtx = document.getElementById("monthlySalesPieChart").getContext("2d");
        if (monthlySalesPieData.length > 0) {
            new Chart(monthlyPieCtx, {
                type: "pie",
                data: {
                    labels: monthlySalesPieData.map(m => m.month_name),
                    datasets: [{
                        label: "Monthly Sales",
                        data: monthlySalesPieData.map(m => m.total_amount),
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.5)",
                            "rgba(54, 162, 235, 0.5)",
                            "rgba(75, 192, 192, 0.5)",
                            "rgba(255, 206, 86, 0.5)",
                            "rgba(153, 102, 255, 0.5)",
                            "rgba(255, 159, 64, 0.5)"
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)"
                        ],
                        borderWidth: 1
                    }]
                }
            });
        }





    </script>
</body>

</html>
