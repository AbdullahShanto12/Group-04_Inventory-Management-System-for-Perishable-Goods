// Sample data to simulate alert records
const alertData = [
    { id: "A001", type: "Low Stock", description: "Stock for item X is below threshold", date: "2024-11-10", status: "Active" },
    { id: "A002", type: "Expired Product", description: "Item Y has expired", date: "2024-11-12", status: "Resolved" },
    { id: "A003", type: "Reorder Reminder", description: "Reorder needed for item Z", date: "2024-11-14", status: "Active" }
];

// Function to display alerts in the table
function displayAlerts() {
    const alertList = document.getElementById('alert-list');
    alertList.innerHTML = '';

    alertData.forEach(alert => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${alert.id}</td>
            <td>${alert.type}</td>
            <td>${alert.description}</td>
            <td>${alert.date}</td>
            <td>${alert.status}</td>
            <td>
                <button class="btn btn-sm btn-danger" onclick="removeAlert('${alert.id}')">Remove</button>
                <button class="btn btn-sm btn-success" onclick="resolveAlert('${alert.id}')">Resolve</button>
            </td>
        `;
        alertList.appendChild(row);
    });
}

// Function to add a new alert
document.getElementById('add-alert-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const alertType = document.getElementById('alert-type').value;
    const alertDescription = document.getElementById('alert-description').value;
    const newAlert = {
        id: `A${alertData.length + 1}`,
        type: alertType,
        description: alertDescription,
        date: new Date().toISOString().split('T')[0],
        status: "Active"
    };
    
    alertData.push(newAlert);
    displayAlerts();
});

// Function to remove an alert
function removeAlert(alertId) {
    const index = alertData.findIndex(alert => alert.id === alertId);
    if (index > -1) {
        alertData.splice(index, 1);
        displayAlerts();
    }
}

// Function to mark an alert as resolved
function resolveAlert(alertId) {
    const alert = alertData.find(alert => alert.id === alertId);
    if (alert) {
        alert.status = "Resolved";
        displayAlerts();
    }
}

// Initial display of alerts
displayAlerts();
