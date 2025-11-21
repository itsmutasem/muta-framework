<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <title>{{ title }}</title>
</head>
<body>
<h1>Product List</h1>
<a href="/products/create">Create Product</a>
<?php foreach ($products as $product) : ?>
    <div>
        <h2>
            <a href="/products/{{ product['id'] }}/show">
                {{ product['name'] }}
            </a>
        </h2>
    </div>
<?php endforeach; ?>
</body>
</html>