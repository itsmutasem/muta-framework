<< extends "base" >>
<< block title >>Edit Product<< endblock >>
<< block body >>
<h1>Delete Product</h1>
<form action="/products/{{ product['id'] }}/destroy" method="post">
    <p>Delete this product?</p>
    <button>Yes</button>
</form>
<p><a href="/products/{{ product['id'] }}/show">Back</a></p>
<< endblock >>
