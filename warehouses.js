$(document).ready(function() {
    // Sample warehouse data
    const warehouseData = [
        { id: "W001", name: "Warehouse 1", location: { lat: 37.7749, lon: -122.4194 }, capacity: 500, stock: 200 },
        { id: "W002", name: "Warehouse 2", location: { lat: 34.0522, lon: -118.2437 }, capacity: 800, stock: 350 },
        { id: "W003", name: "Warehouse 3", location: { lat: 40.7128, lon: -74.0060 }, capacity: 1000, stock: 450 }
    ];

    // Initialize Leaflet map
    const map = L.map('warehouse-map').setView([37.7749, -122.4194], 4); // Default view: centered on San Francisco

    // Add a tile layer to the map
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Function to render warehouse list in the table
    function renderWarehouseList() {
        const warehouseList = $("#warehouse-list");
        warehouseList.empty(); // Clear current list

        warehouseData.forEach(function(warehouse) {
            const row = `<tr>
                <td>${warehouse.id}</td>
                <td>${warehouse.name}</td>
                <td>${warehouse.location.lat}, ${warehouse.location.lon}</td>
                <td>${warehouse.capacity}</td>
                <td>${warehouse.stock}</td>
                <td>
                    <button class="btn btn-sm btn-danger" onclick="removeWarehouse('${warehouse.id}')">Remove</button>
                    <button class="btn btn-sm btn-primary" onclick="editWarehouse('${warehouse.id}')">Edit</button>
                    <button class="btn btn-info btn-sm" onclick="showOnMap('${warehouse.id}')">View on Map</button>
                </td>
            </tr>`;
            warehouseList.append(row);
        });
    }

    // Function to initialize the map and add warehouse markers
    function initMap() {
        // Clear existing markers before re-adding
        map.eachLayer(function(layer) {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        warehouseData.forEach(warehouse => {
            L.marker([warehouse.location.lat, warehouse.location.lon])
                .addTo(map)
                .bindPopup(`<b>${warehouse.name}</b><br>Capacity: ${warehouse.capacity}<br>Stock Level: ${warehouse.stock}`);
        });
    }

    // Function to add or update a warehouse (depending on whether it's a new warehouse or an edit)
    $("#add-warehouse-form").submit(function(e) {
        e.preventDefault();

        const name = $("#warehouse-name").val();
        const locationInput = $("#warehouse-location").val().split(",");
        const capacity = $("#warehouse-capacity").val();
        const stock = $("#warehouse-stock").val();

        // Check if we are editing an existing warehouse or adding a new one
        if ($("#warehouse-id").val()) {
            const id = $("#warehouse-id").val();
            const warehouse = warehouseData.find(w => w.id === id);

            if (warehouse) {
                // Update the warehouse if it's an edit
                warehouse.name = name;
                warehouse.location = { lat: parseFloat(locationInput[0]), lon: parseFloat(locationInput[1]) };
                warehouse.capacity = parseInt(capacity);
                warehouse.stock = parseInt(stock);
            }
        } else {
            // Add new warehouse if not in edit mode
            const id = "W" + (warehouseData.length + 1).toString().padStart(3, "0");
            const newWarehouse = {
                id: id,
                name: name,
                location: { lat: parseFloat(locationInput[0]), lon: parseFloat(locationInput[1]) },
                capacity: parseInt(capacity),
                stock: parseInt(stock)
            };
            warehouseData.push(newWarehouse);
        }

        // Clear the form and update the list and map
        $("#add-warehouse-form")[0].reset(); // Reset form
        renderWarehouseList();
        initMap();
    });

    // Function to remove a warehouse
    window.removeWarehouse = function(id) {
        const index = warehouseData.findIndex(warehouse => warehouse.id === id);
        if (index > -1) {
            warehouseData.splice(index, 1);
            renderWarehouseList();
            initMap();
        }
    };

    // Function to edit warehouse details
    window.editWarehouse = function(id) {
        const warehouse = warehouseData.find(w => w.id === id);
        if (warehouse) {
            // Fill the form with the current warehouse details
            $("#warehouse-id").val(warehouse.id);
            $("#warehouse-name").val(warehouse.name);
            $("#warehouse-location").val(`${warehouse.location.lat}, ${warehouse.location.lon}`);
            $("#warehouse-capacity").val(warehouse.capacity);
            $("#warehouse-stock").val(warehouse.stock);
        }
    };

    // Function to show warehouse location on map
    window.showOnMap = function(id) {
        const warehouse = warehouseData.find(w => w.id === id);
        if (warehouse) {
            map.setView([warehouse.location.lat, warehouse.location.lon], 10); // Zoom to warehouse location
            L.marker([warehouse.location.lat, warehouse.location.lon]).addTo(map)
                .bindPopup(`<b>${warehouse.name}</b><br>Capacity: ${warehouse.capacity}<br>Stock Level: ${warehouse.stock}`);
        }
    };

    // Initially render warehouse list and set up map
    renderWarehouseList();
    initMap();
});
