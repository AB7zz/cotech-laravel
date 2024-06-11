<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Edit Product</h1>
    <form action="{{ route('products.update', $product['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" class="form-control" id="productName" name="product_name" value="{{ $product['productName'] }}" required>
        </div>
        <div class="form-group">
            <label for="quantityInStock">Quantity in Stock</label>
            <input type="number" class="form-control" id="quantityInStock" name="quantity_in_stock" value="{{ $product['quantityInStock'] }}" required>
        </div>
        <div class="form-group">
            <label for="pricePerItem">Price per Item</label>
            <input type="number" class="form-control" id="pricePerItem" name="price_per_item" value="{{ $product['pricePerItem'] }}" step="0.01" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
