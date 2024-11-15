function searchEmployee() {
    const employeeId = document.getElementById('employee-id').value;
    // Mock employee data for demonstration purposes
    const employeeData = {
        "E123": { name: "Alice Johnson", department: "Sales", phone: "555-1234" },
        "E456": { name: "Bob Smith", department: "IT", phone: "555-5678" },
        "E789": { name: "Charlie Brown", department: "Marketing", phone: "555-8765" }
    };
    
    const employee = employeeData[employeeId];
    if (employee) {
        document.getElementById('employee-name').textContent = employee.name;
        document.getElementById('employee-department').textContent = employee.department;
        document.getElementById('employee-phone').textContent = employee.phone;
        document.getElementById('employee-details').style.display = 'block';
    } else {
        alert("Employee not found");
        document.getElementById('employee-details').style.display = 'none';
    }
}
