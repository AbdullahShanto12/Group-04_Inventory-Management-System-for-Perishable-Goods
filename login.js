// Function to handle login submission
function handleLogin(event) {
    event.preventDefault();

    // Get input values
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    const errorMessage = document.getElementById('error-message');

    // Retrieve user data from local storage
    const storedUser = JSON.parse(localStorage.getItem('user'));

    // Check if stored credentials match entered values
    if (storedUser && username === storedUser.username && password === storedUser.password && role === storedUser.role) {
        // Redirect to dashboard if credentials match
        window.location.href = "dashboard.html";
    } else {
        // Show error message if credentials don't match
        errorMessage.textContent = "Invalid username, password, or role.";
        errorMessage.style.color = "red";
    }
}

// Attach the function to form submission
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("login-form").addEventListener("submit", handleLogin);
});
