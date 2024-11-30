class StorageDashboard {
    constructor() {
        this.storageData = [
            {
                name: 'Primary Storage',
                total: 5000,
                health: 'healthy',
                temperature: 22,
                targetTemp: 22,
                humidity: 45,
                targetHumidity: 45,
                goods: [
                    { name: 'Rice', quantity: 500, unit: 'kg' },
                    { name: 'Wheat', quantity: 300, unit: 'kg' }
                ]
            },
            {
                name: 'Backup Storage',
                total: 3000,
                health: 'warning',
                temperature: 20,
                targetTemp: 20,
                humidity: 50,
                targetHumidity: 50,
                goods: [
                    { name: 'Sugar', quantity: 250, unit: 'kg' },
                    { name: 'Salt', quantity: 100, unit: 'kg' }
                ]
            }
        ];

        // Calculate initial used storage based on goods
        this.storageData.forEach(storage => {
            storage.used = storage.goods.reduce((sum, good) => sum + good.quantity, 0);
        });

        this.render();
        this.startEnvironmentControl();
    }

    startEnvironmentControl() {
        setInterval(() => {
            this.storageData.forEach((storage, index) => {
                const tempDiff = storage.targetTemp - storage.temperature;
                const humidityDiff = storage.targetHumidity - storage.humidity;
                
                storage.temperature = Number((storage.temperature + (Math.random() * 0.4 * Math.sign(tempDiff))).toFixed(1));
                storage.humidity = Number((storage.humidity + (Math.random() * 0.5 * Math.sign(humidityDiff))).toFixed(1));
                storage.health = Math.abs(tempDiff) > 5 || Math.abs(humidityDiff) > 10 ? 'warning' : 'healthy';

                // Update only the dynamic elements
                const card = document.querySelectorAll('.card')[index];
                if (card) {
                    card.querySelector('.status-icon').className = `status-icon ${storage.health}`;
                    card.querySelectorAll('.metric-box')[0].querySelector('div:last-child').textContent = `${storage.temperature}°C`;
                    card.querySelectorAll('.metric-box')[1].querySelector('div:last-child').textContent = `${storage.humidity}%`;
                }
            });
        }, 3000);
    }

    showAlert(message, isError = false) {
        const alert = document.createElement('div');
        alert.className = `alert ${isError ? 'alert-error' : 'alert-success'}`;
        alert.innerHTML = message;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    }

    confirmDelete(storageName, goodName) {
        const confirmed = confirm(`Are you sure you want to remove ${goodName}?`);
        if (confirmed) {
            this.removeGood(storageName, goodName);
        }
    }

    handleAdd(storageName, button) {
        const form = button.parentElement;
        const goodName = form.querySelector('.good-name').value;
        const quantity = Number(form.querySelector('.good-quantity').value);
        const unit = form.querySelector('.good-unit').value;

        if (!goodName || !quantity || !unit) {
            this.showAlert('Please fill in all fields', true);
            return;
        }

        const storage = this.storageData.find(s => s.name === storageName);
        const newTotal = storage.used + quantity;
        
        if (newTotal > storage.total) {
            this.showAlert(`Cannot add: Storage capacity exceeded (${newTotal}/${storage.total} ${unit})`, true);
            return;
        }

        this.addGood(storageName, goodName, quantity, unit);
        form.querySelector('.good-name').value = '';
        form.querySelector('.good-quantity').value = '';
    }

    addGood(storageName, goodName, quantity, unit) {
        const storage = this.storageData.find(s => s.name === storageName);
        if (storage) {
            const existingGood = storage.goods.find(g => g.name === goodName);
            if (existingGood) {
                existingGood.quantity += Number(quantity);
            } else {
                storage.goods.push({ name: goodName, quantity: Number(quantity), unit });
            }
            storage.used = storage.goods.reduce((sum, good) => sum + good.quantity, 0);
            this.showAlert(`Successfully added ${quantity}${unit} of ${goodName}`);
            this.render();
        }
    }

    removeGood(storageName, goodName) {
        const storage = this.storageData.find(s => s.name === storageName);
        if (storage) {
            storage.goods = storage.goods.filter(g => g.name !== goodName);
            storage.used = storage.goods.reduce((sum, good) => sum + good.quantity, 0);
            this.showAlert(`Successfully removed ${goodName}`);
            this.render();
        }
    }

    editGood(storageName, goodName) {
        const storage = this.storageData.find(s => s.name === storageName);
        const good = storage.goods.find(g => g.name === goodName);
        
        if (!good) return;

        const newQuantity = prompt(`Enter new quantity for ${goodName}:`, good.quantity);
        if (newQuantity === null) return;

        const quantity = Number(newQuantity);
        if (isNaN(quantity) || quantity < 0) {
            this.showAlert('Please enter a valid quantity', true);
            return;
        }

        const currentTotal = storage.used - good.quantity;
        const newTotal = currentTotal + quantity;

        if (newTotal > storage.total) {
            this.showAlert(`Cannot update: Storage capacity exceeded (${newTotal}/${storage.total} ${good.unit})`, true);
            return;
        }

        good.quantity = quantity;
        storage.used = storage.goods.reduce((sum, good) => sum + good.quantity, 0);
        this.showAlert(`Successfully updated ${goodName}`);
        this.render();
    }

    adjustEnvironment(storageName, type, value) {
        const storage = this.storageData.find(s => s.name === storageName);
        if (storage) {
            storage[type === 'temperature' ? 'targetTemp' : 'targetHumidity'] = Number(value);
        }
    }

    render() {
        const mainContent = document.getElementById('mainContent');
        mainContent.innerHTML = this.storageData.map(storage => `
            <div class="card">
                <div class="storage-header">
                    <div class="status-icon ${storage.health}"></div>
                    <h3>${storage.name}</h3>
                </div>

                <div class="progress-bar">
                    <div class="progress" style="width: ${(storage.used/storage.total*100)}%"></div>
                </div>
                <div>${((storage.used/storage.total)*100).toFixed(1)}% Used 
                    (${storage.used}/${storage.total} kg)</div>

                <div class="metrics-grid">
                    <div class="metric-box">
                        <div>Temperature:
                            <input type="number" 
                                value="${storage.targetTemp}" 
                                onchange="dashboard.adjustEnvironment('${storage.name}', 'temperature', this.value)"
                                class="environment-control"
                            >°C
                        </div>
                        <div>${storage.temperature}°C</div>
                    </div>
                    <div class="metric-box">
                        <div>Humidity:
                            <input type="number" 
                                value="${storage.targetHumidity}" 
                                onchange="dashboard.adjustEnvironment('${storage.name}', 'humidity', this.value)"
                                class="environment-control"
                            >%
                        </div>
                        <div>${storage.humidity}%</div>
                    </div>
                </div>

                <h4>Inventory</h4>
                <div class="inventory-grid">
                    ${storage.goods.map(good => `
                        <div class="inventory-item">
                            <span>${good.name}: ${good.quantity} ${good.unit}</span>
                            <div class="item-controls">
                                <button onclick="dashboard.editGood('${storage.name}', '${good.name}')" class="edit-btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="dashboard.confirmDelete('${storage.name}', '${good.name}')" class="remove-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `).join('')}
                </div>

                <div class="add-form">
                    <input type="text" placeholder="Good Name" class="good-name">
                    <input type="number" placeholder="Quantity" class="good-quantity">
                    <select class="good-unit">
                        <option value="kg">kg</option>
                        <option value="liters">liters</option>
                        <option value="units">units</option>
                    </select>
                    <button onclick="dashboard.handleAdd('${storage.name}', this)">Add</button>
                </div>
            </div>
        `).join('');
    }
}

const dashboard = new StorageDashboard();