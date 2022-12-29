<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Import Excel Here!</h1>
    {{ Form::open([ 'route' => 'products.store', 'files' => 'true'  ]) }}
        <div class="form-group">
            {{ Form::file('file')}}
        </div>
        <button type="submit" class="btn btn-primary">Import Excel</button>
    {{ Form::close() }}
</body>
</html>