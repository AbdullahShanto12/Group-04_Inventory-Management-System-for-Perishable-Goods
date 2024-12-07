<?php
// Database connection
$servername = "localhost";
$username = "root";  // XAMPP default username
$password = "";      // XAMPP default password
$dbname = "inventory_goods";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password
    $role = $_POST['role'];  // Assuming role is selected in the form (e.g., 'user' or 'admin')

    // SQL to insert user data into the users table
    $sql = "INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)";

    // Prepare and bind the query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullName, $email, $password, $role);  // Bind the variables to the SQL query

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "New user registered successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Inventory</b>System</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>

            <form method="POST" action="signup.php">
                <div class="input-group mb-3">
                    <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Full name" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="input-group mb-3">
                    <label for="role" class="form-control-label">Select Role:</label>
                    <select id="role" name="role" class="form-control" required>
                    <option value="" disabled selected>Select your role</option>
                        <option value="admin">Admin</option>
                        <option value="editor_Sales">Sales Officer</option>
                        <option value="editor_Product">Product Officer</option>
                        <option value="editor_Warehouse">Warehouse Manager</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agree" required>
                            <label for="agree">
                                I agree to the <a href="#">terms and conditions</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </div>
                </div>
            </form>

            <p class="mb-1">
                <a href="login.html">I already have a membership</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
