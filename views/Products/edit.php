<h1>Edit Product</h1>
<form action="/products/<?= $product['id'] ?>/update" method="post">
    <?= require 'form.php' ?>
</form>
<p><a href="/products/<?= $product['id'] ?>/show">Back</a></p>
</body>
</html>
