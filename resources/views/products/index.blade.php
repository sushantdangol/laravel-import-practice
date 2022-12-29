<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <title>Product Price List</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Import Excel File</a>
                <form action={{route('products.index')}} method="GET">
                    <div>
                        <label for="month">Months</label>
                        <select class="form-control" id="month" name="month">
                            @foreach($months as $key=>$value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Filter Date</button>
                </form>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">CODE</th>
                        <th scope="col">PRODUCT NAME</th>
                        <th scope="col">COLOUR NAME</th>
                        <th scope="col">TAX CODE</th>
                        <th scope="col">UNIT OF MEASURE</th>
                        <th scope="col">TYPE</th>
                        <th scope="col">COST</th>
                        <th scope="col">PRICES</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                      <tr>
                        <td>{{$product->code}}</td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->colour}}</td>
                        <td>{{$product->tax_code}}</td>
                        <td>{{$product->unit->name}}</td>
                        <td>{{$product->productType->name}}</td>
                        <td>{{$product->cost}}</td>
                        <td>
                        <table class="table">
                        @foreach(collect($product->productPrices)->where('created_at', '>', '2022-'.request()->month.'-01 00:00:00')->where('created_at', '<', '2022-'.request()->month.'-30 23:59:59') as $productPrice)
                            @foreach(json_decode($productPrice->prices) as $price)
                            <tr><th scope="col">{{str_replace('_', ' ', strtoupper($price->key))}}</th>
                            <td>{{$price->value}}</td></tr>
                            @endforeach
                        @endforeach
                        </table>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
</body>
</html>