<h1>Product List</h1>
<a href="/products/create">Create Product</a>
<?php foreach ($products as $product) : ?>
    <div>
        <h2>
            <a href="/products/<?= $product['id'] ?>/show">
                <?= htmlspecialchars($product['name']) ?>
            </a>
        </h2>
    </div>
<?php endforeach; ?>
</body>
</html>