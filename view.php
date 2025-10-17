<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
</head>
<body>
<h1>Product List</h1>
<?php foreach ($products as $product) : ?>
    <div>
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p>Description: <?php echo htmlspecialchars($product['description']); ?></p>
    </div>
<?php endforeach; ?>
</body>
</html>