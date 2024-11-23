// Example products
let products = [
    { id: '#101', name: 'Milk - Full Cream', category: 'Dairy', stock: 250, price: 3.50 },
    { id: '#102', name: 'Cheddar Cheese', category: 'Dairy', stock: 120, price: 5.25 },
    { id: '#103', name: 'Organic Eggs', category: 'Eggs', stock: 450, price: 2.00 },
    { id: '#104', name: 'Fresh Butter', category: 'Dairy', stock: 80, price: 4.75 }
];

// Function to render products in the table
function renderProducts() {
    const productList = document.querySelector('#product-list');
    productList.innerHTML = ''; // Clear current list

    products.forEach(product => {
        const productRow = document.createElement('tr');
        productRow.id = `product-${product.id}`;

        productRow.innerHTML = `
            <td>${product.id}</td>
            <td>${product.name}</td>
            <td>${product.category}</td>
            <td>${product.stock}</td>
            <td>$${product.price.toFixed(2)}</td>
            <td>
                <button class="btn btn-primary btn-sm" onclick="viewProduct('${product.id}')">
                    <i class="fas fa-folder"></i> View
                </button>
                <button class="btn btn-info btn-sm" onclick="editProduct('${product.id}')">
                    <i class="fas fa-pencil-alt"></i> Edit
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteProduct('${product.id}')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </td>
        `;
        productList.appendChild(productRow);
    });
}

// Function to handle viewing a product
function viewProduct(productId) {
    const product = products.find(p => p.id === productId);
    if (product) {
        alert(`Product Details:\n\nID: ${product.id}\nName: ${product.name}\nCategory: ${product.category}\nStock: ${product.stock}\nPrice: $${product.price.toFixed(2)}`);
    }
}

// Function to handle adding a new product
document.querySelector('#add-product-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const productName = document.querySelector('#product-name').value;
    const productCategory = document.querySelector('#product-category').value;
    const stockQuantity = Number(document.querySelector('#stock-quantity').value);
    const productPrice = parseFloat(document.querySelector('#product-price').value);

    const newProduct = {
        id: `#${products.length + 101}`,
        name: productName,
        category: productCategory,
        stock: stockQuantity,
        price: productPrice
    };

    products.push(newProduct);
    renderProducts();

    // Reset form fields
    document.querySelector('#add-product-form').reset();
});

// Function to handle editing a product
function editProduct(productId) {
    // Find the product to edit
    const product = products.find(p => p.id === productId);

    if (product) {
        // Fill the form fields with the existing product data
        document.querySelector('#edit-product-id').value = product.id;
        document.querySelector('#edit-product-name').value = product.name;
        document.querySelector('#edit-product-category').value = product.category;
        document.querySelector('#edit-stock-quantity').value = product.stock;
        document.querySelector('#edit-product-price').value = product.price;

        // Show the modal
        $('#editProductModal').modal('show');

        // Save changes when the "Save changes" button is clicked
        document.querySelector('#save-edit-button').onclick = function () {
            const updatedProduct = {
                id: document.querySelector('#edit-product-id').value,
                name: document.querySelector('#edit-product-name').value,
                category: document.querySelector('#edit-product-category').value,
                stock: Number(document.querySelector('#edit-stock-quantity').value),
                price: parseFloat(document.querySelector('#edit-product-price').value)
            };

            // Update the product in the products array
            const index = products.findIndex(p => p.id === productId);
            if (index !== -1) {
                products[index] = updatedProduct;
                renderProducts(); // Re-render the table after update
                $('#editProductModal').modal('hide'); // Close the modal
            }
        };
    }
}

// Function to handle deleting a product
function deleteProduct(productId) {
    if (confirm(`Are you sure you want to delete product ${productId}?`)) {
        products = products.filter(product => product.id !== productId);
        renderProducts();
    }
}

// Initialize the product list on page load
document.addEventListener('DOMContentLoaded', renderProducts);
