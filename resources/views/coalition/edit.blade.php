<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>PHP Skills Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form action="{{ route('coalition.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" value="{{ $product->productName }}" required>
            </div>
            <div class="form-group">
                <label for="quantityInStock">Quantity In Stock</label>
                <input type="number" class="form-control" id="quantityInStock" name="quantityInStock" value="{{ $product->quantityInStock }}" required>
            </div>
            <div class="form-group">
                <label for="pricePerItem">Price Per Item</label>
                <input type="text" class="form-control" id="pricePerItem" name="pricePerItem" value="{{ $product->pricePerItem }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>