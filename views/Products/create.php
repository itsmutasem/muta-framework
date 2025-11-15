<h1>New Product</h1>
<form action="/products/store" method="post">
    <label for="name">Name</label>
    <input type="text" name="name" id="name">

    <?php
    if(isset($errors['name'])) : ?>
        <p><?= $errors['name'] ?></p>
    <?php endif; ?>

    <label for="description">Description</label>
    <textarea name="description" id="description" cols="30" rows="10"></textarea>
    <button type="submit">Create</button>
</form>