<?php
// Include database connection file
include('connect.php');

// Fetch alerts from the database
$query = "SELECT * FROM alerts";
$result = $conn->query($query);

// Initialize an array to store the fetched alerts
$alerts = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $alerts[] = $row;
    }
} else {
    // If no alerts found, return an empty array
    $alerts = [];
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alerts - Inventory Management System</title>

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
</head>


<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="dashboard.php" class="nav-link">Home</a>
            </li>
  
        </ul>
    </nav>
    <!-- /.navbar -->
     

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">Inventory System</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
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
                        <a href="alerts.php" class="nav-link active">
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
        <!-- /.sidebar -->
    </aside>
    
    
    
    
    
    
    
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Alerts</h1>
                    </div>
                </div>
            </div>
        </section>
    
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Alerts Table Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Inventory Alerts</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addAlertModal">
                        <i class="fas fa-plus"></i> Add Alert
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 10%">Alert ID</th>
                            <th style="width: 15%">Alert Type</th>
                            <th style="width: 25%">Description</th>
                            <th style="width: 15%">Date</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alerts as $alert): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($alert['alert_id']); ?></td>
                                <td><?php echo htmlspecialchars($alert['alert_type']); ?></td>
                                <td><?php echo htmlspecialchars($alert['description']); ?></td>
                                <td><?php echo htmlspecialchars($alert['alert_date']); ?></td>
                                <td><?php echo htmlspecialchars($alert['status']); ?></td>
                                <td>
                                    <!-- View Button -->
                                    <button class="btn btn-info" 
                                        data-toggle="modal" 
                                        data-target="#viewAlertModal" 
                                        data-id="<?php echo $alert['alert_id']; ?>"
                                        data-type="<?php echo $alert['alert_type']; ?>"
                                        data-description="<?php echo $alert['description']; ?>"
                                        data-date="<?php echo $alert['alert_date']; ?>"
                                        data-status="<?php echo $alert['status']; ?>">View
                                    </button>
                                    
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning" 
                                        data-toggle="modal" 
                                        data-target="#editAlertModal" 
                                        data-id="<?php echo $alert['alert_id']; ?>"
                                        data-type="<?php echo $alert['alert_type']; ?>"
                                        data-description="<?php echo $alert['description']; ?>"
                                        data-date="<?php echo $alert['alert_date']; ?>"
                                        data-status="<?php echo $alert['status']; ?>">Edit
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <button class="btn btn-danger" 
                                        data-toggle="modal" 
                                        data-target="#deleteAlertModal" 
                                        data-id="<?php echo $alert['alert_id']; ?>">Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


    
        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
            All rights reserved.
        </footer>
    </div>
    
<!-- ./wrapper -->




    
<!-- Add Alert Modal -->
<div class="modal fade" id="addAlertModal" tabindex="-1" role="dialog" aria-labelledby="addAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAlertModalLabel">Add New Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-alert.php" method="POST">
                    <div class="form-group">
                        <label for="alertType">Alert Type</label>
                        <input type="text" class="form-control" name="alert_type" id="alertType" required>
                    </div>
                    <div class="form-group">
                        <label for="alertDescription">Description</label>
                        <textarea class="form-control" name="description" id="alertDescription" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="alertDate">Date</label>
                        <input type="date" class="form-control" name="alert_date" id="alertDate" required>
                    </div>
                    <div class="form-group">
                        <label for="alertStatus">Status</label>
                        <select class="form-control" name="status" id="alertStatus" required>
                            <option value="Active">Active</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Closed">Closed</option>

                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Alert</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Delete Alert Modal -->
<div class="modal fade" id="deleteAlertModal" tabindex="-1" aria-labelledby="deleteAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAlertModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this alert?</p>
                <input type="hidden" id="alertIdToDelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteAlertButton" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

    
<!-- Edit Alert Modal -->
<div class="modal fade" id="editAlertModal" tabindex="-1" aria-labelledby="editAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAlertModalLabel">Edit Alert</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editAlertForm">
                    <input type="hidden" id="editAlertId" name="alert_id">
                    <div class="form-group">
                        <label for="editAlertType">Alert Type</label>
                        <input type="text" class="form-control" id="editAlertType" name="alert_type" required>
                    </div>
                    <div class="form-group">
                        <label for="editAlertDescription">Description</label>
                        <textarea class="form-control" id="editAlertDescription" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editAlertDate">Date</label>
                        <input type="date" class="form-control" id="editAlertDate" name="alert_date" required>
                    </div>
                    <div class="form-group">
                        <label for="editAlertStatus">Status</label>
                        <select class="form-control" id="editAlertStatus" name="status" required>
                            <option value="Active">Active</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Closed">Closed</option>

                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="saveEditAlertButton" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>

    
<!-- View Alert Modal -->
<div class="modal fade" id="viewAlertModal" tabindex="-1" role="dialog" aria-labelledby="viewAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAlertModalLabel">Alert Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Alert Type:</strong> <span id="viewAlertType"></span></p>
                <p><strong>Description:</strong> <span id="viewAlertDescription"></span></p>
                <p><strong>Date:</strong> <span id="viewAlertDate"></span></p>
                <p><strong>Status:</strong> <span id="viewAlertStatus"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>









<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- External JavaScript -->
<script src="alerts.js"></script>





<script>





// View Alert Modal
$('#viewAlertModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget); // Button that triggered the modal
    const alertId = button.data('id');
    const alertType = button.data('type');
    const alertDescription = button.data('description');
    const alertDate = button.data('date');
    const alertStatus = button.data('status');

    // Populate the modal fields with data
    $('#viewAlertType').text(alertType);
    $('#viewAlertDescription').text(alertDescription);
    $('#viewAlertDate').text(alertDate);
    $('#viewAlertStatus').text(alertStatus);
});





// Edit Alert Modal
// When the edit modal is about to be shown for editing an alert
$('#editAlertModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var alertId = button.data('id'); // Extract alert data from data-* attributes
    var alertType = button.data('type');
    var description = button.data('description');
    var alertDate = button.data('date');
    var status = button.data('status');

    // Set the values in the modal fields
    $('#editAlertId').val(alertId);
    $('#editAlertType').val(alertType);
    $('#editAlertDescription').val(description);
    $('#editAlertDate').val(alertDate);
    $('#editAlertStatus').val(status);
});

// When the save button is clicked in the edit alert modal
$('#saveEditAlertButton').click(function () {
    // Serialize the form data
    var formData = $('#editAlertForm').serialize();

    // Send an AJAX request to update the alert
    $.ajax({
        type: "POST",
        url: "update-alert.php", // PHP script to handle the update
        data: formData,
        success: function (response) {
            // Close the modal
            $('#editAlertModal').modal('hide');

            // Display the response and refresh the page or update the UI
            alert(response);
            location.reload(); // Reload the page to reflect changes
        },
        error: function () {
            alert('Error updating alert.');
        }
    });
});








// Delete Alert Modal
$('#deleteAlertModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget); // Button that triggered the modal
    const alertId = button.data('id');

    // Set the alert ID in the hidden input field
    $('#alertIdToDelete').val(alertId);
});

// Confirm Delete Alert
$('#confirmDeleteAlertButton').on('click', function () {
    const alertId = $('#alertIdToDelete').val();

    // Send AJAX request to delete the alert
    $.ajax({
        url: 'delete-alert.php',
        type: 'POST',
        data: { alert_id: alertId },
        success: function (response) {
            // Handle success response
            alert('Alert deleted successfully!');
            location.reload(); // Refresh the page
        },
        error: function (xhr, status, error) {
            // Handle error response
            console.error(error);
            alert('Error deleting alert. Please try again.');
        }
    });
});




</script>











</body>
</html>
