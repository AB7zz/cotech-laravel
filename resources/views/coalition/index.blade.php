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
        <h1>PHP Skills Test</h1>
        <form id="productForm">
            @csrf
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="form-group">
                <label for="quantityInStock">Quantity In Stock</label>
                <input type="number" class="form-control" id="quantityInStock" name="quantityInStock" required>
            </div>
            <div class="form-group">
                <label for="pricePerItem">Price Per Item</label>
                <input type="text" class="form-control" id="pricePerItem" name="pricePerItem" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity in Stock</th>
                    <th>Price Per Item</th>
                    <th>Datetime Submitted</th>
                    <th>Total Value Number</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody id="productTableBody">

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5"><strong>Sum Total:</strong></td>
                    <td id="sumTotalValue">{{ $sumTotalValue }}</td>
                </tr>
            </tfoot>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#productForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('coalition.store') }}',
                    data: $(this).serialize(),
                    success: function(response) {
                        if(response.success){
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
                                `)
                            });

                            $('#sumTotalValue').text(sumTotalValue);
                            $('#productForm')[0].reset();
                        }
                    },
                    error: function(response) {
                        alert('Err');
                    }
                })
            })
        })
    </script>
</body>
</html>
