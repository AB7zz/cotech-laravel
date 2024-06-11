<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PHP Skills Test</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>PHP Skills Test</h1>
    <form id="productForm">
        @csrf
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" class="form-control" id="productName" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="quantityInStock">Quantity in Stock</label>
            <input type="number" class="form-control" id="quantityInStock" name="quantity_in_stock" required>
        </div>
        <div class="form-group">
            <label for="pricePerItem">Price per Item</label>
            <input type="number" class="form-control" id="pricePerItem" name="price_per_item" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <hr>
    <table class="table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity in Stock</th>
            <th>Price per Item</th>
            <th>Datetime Submitted</th>
            <th>Total Value Number</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="productTableBody">
        @foreach ($products as $product)
            <tr>
                <td>{{ $product['productName'] }}</td>
                <td>{{ $product['quantityInStock'] }}</td>
                <td>{{ $product['pricePerItem'] }}</td>
                <td>{{ $product['dateTimeSubmitted'] }}</td>
                <td>{{ $product['totalValueNumber'] }}</td>
                <td><a href="{{ route('products.edit', $product['id']) }}" class="btn btn-warning btn-sm">Edit</a></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5"><strong>Sum Total:</strong></td>
            <td id="sumTotalValue">{{ $sumTotalValue }}</td>
        </tr>
        </tfoot>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#productForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                type: 'POST',
                url: '{{ route('products.store') }}',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        let products = response.products;
                        let sumTotalValue = response.sumTotalValue;

                        $('#productTableBody').empty();
                        products.forEach(product => {
                            $('#productTableBody').append(`
                                <tr>
                                    <td>${product.productName}</td>
                                    <td>${product.quantityInStock}</td>
                                    <td>${product.pricePerItem}</td>
                                    <td>${product.dateTimeSubmitted}</td>
                                    <td>${product.totalValueNumber}</td>
                                    <td><a href="/products/${product.id}/edit" class="btn btn-warning btn-sm">Edit</a></td>
                                </tr>
                            `);
                        });

                        $('#sumTotalValue').text(sumTotalValue);
                        $('#productForm')[0].reset();
                    }
                },
                error: function(response) {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>
</body>
</html>
