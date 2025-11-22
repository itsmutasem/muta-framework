<< extends "base" >>
<< block title >>New Product<< endblock >>
<< block body >>
<h1>New Product</h1>
<form action="/products/store" method="post">
<?= require '../views/Products/form.mvc.php' ?>
</form>
<< endblock >>