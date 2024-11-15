document.getElementById('addWarehouseBtn').addEventListener('click', function() {
    document.getElementById('addWarehouseModal').style.display = 'block';
});

document.getElementById('addWarehouseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var name = document.getElementById('warehouse-name').value;
    var location = document.getElementById('warehouse-location').value;
    var capacity = document.getElementById('warehouse-capacity').value;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'addWarehouse.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status == 200) {
            alert('Warehouse added successfully');
            location.reload(); // Reload the page to show the updated list of warehouses
        } else {
            alert('Error: ' + xhr.status);
        }
    };
    xhr.send('warehouse-name=' + name + '&warehouse-location=' + location + '&warehouse-capacity=' + capacity);
});

function closeModal() {
    document.getElementById('addWarehouseModal').style.display = 'none';
}

function showSection(sectionId) {
    var sections = document.querySelectorAll('.content-section');
    sections.forEach(function(section) {
        section.style.display = section.id === sectionId ? 'block' : 'none';
    });
}
