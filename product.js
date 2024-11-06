// product.js
$(document).ready(function () {
    // Example products
    let products = [
        { id: '#101', name: 'Milk - Full Cream', category: 'Dairy', stock: 250, price: 3.50 },
        { id: '#102', name: 'Cheddar Cheese', category: 'Dairy', stock: 120, price: 5.25 },
        { id: '#103', name: 'Organic Eggs', category: 'Eggs', stock: 450, price: 2.00 },
        { id: '#104', name: 'Fresh Butter', category: 'Dairy', stock: 80, price: 4.75 }
    ];

    // Function to render products in the table
    function renderProducts() {
        const productList = $('#product-list');
        productList.empty(); // Clear current list
        products.forEach(product => {
            const productRow = `
                <tr id="product-${product.id}">
                    <td>${product.id}</td>
                    <td>${product.name}</td>
                    <td>${product.category}</td>
                    <td>${product.stock}</td>
                    <td>$${product.price}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-folder"></i> View
                        </a>
                        <a class="btn btn-info btn-sm" href="#">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <button class="btn btn-danger btn-sm" onclick="deleteProduct('${product.id}')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;
            productList.append(productRow);
        });
    }

    // Handle add product
    $('#add-product-form').submit(function (e) {
        e.preventDefault();
        const productName = $('#product-name').val();
        const productCategory = $('#product-category').val();
        const stockQuantity = $('#stock-quantity').val();
        const productPrice = $('#product-price').val();

        // Add new product to the list
        const newProduct = {
            id: `#${products.length + 101}`,
            name: productName,
            category: productCategory,
            stock: stockQuantity,
            price: productPrice
        };

        products.push(newProduct);
        renderProducts();
        $('#add-product-form')[0].reset(); // Reset form fields
    });

    // Delete product
    window.deleteProduct = function (productId) {
        products = products.filter(product => product.id !== productId);
        renderProducts();
    };

    renderProducts(); // Initial render of products
});

