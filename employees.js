// Mock employee data
const employeeData = {
    "E123": { name: "Alice Johnson", department: "Sales", phone: "555-1234", jobTitle: "Sales Manager", location: "New York", yearsOfService: 5 },
    "E456": { name: "Bob Smith", department: "IT", phone: "555-5678", jobTitle: "Software Developer", location: "San Francisco", yearsOfService: 3 },
    "E789": { name: "Charlie Brown", department: "Marketing", phone: "555-8765", jobTitle: "Marketing Specialist", location: "Chicago", yearsOfService: 2 }
};

// Dark mode toggle
document.getElementById('dark-mode-toggle').addEventListener('click', () => {
    document.body.classList.toggle('dark-mode');
});

// Search employee by ID
function searchEmployee() {
    const employeeId = document.getElementById('employee-id').value;
    const employee = employeeData[employeeId];
    const spinner = document.getElementById('loading-spinner');

    spinner.style.display = 'block';
    setTimeout(() => {
        spinner.style.display = 'none';
        if (employee) {
            displayEmployeeDetails(employee);
        } else {
            alert("Employee not found");
            document.getElementById('employee-details').style.display = 'none';
        }
    }, 1000);
}

// Display employee details
function displayEmployeeDetails(employee) {
    document.getElementById('employee-name').textContent = employee.name;
    document.getElementById('employee-department').textContent = employee.department;
    document.getElementById('employee-phone').textContent = employee.phone;
    document.getElementById('employee-job-title').textContent = employee.jobTitle;
    document.getElementById('employee-location').textContent = employee.location;
    document.getElementById('employee-years').textContent = employee.yearsOfService;

    document.getElementById('employee-details').style.display = 'block';
}

// Filter employees by category
function filterByCategory(department) {
    alert(`Filtering employees in the ${department} department.`);
}
