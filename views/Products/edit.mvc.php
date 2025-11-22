<< extends "base" >>
<< block title >>Edit Product<< endblock >>
<< block body >>
<h1>Edit Product</h1>
<form action="/products/{{ product['id'] }}/update" method="post">
    << include "Products/form" >>
</form>
<p><a href="/products/{{ product['id'] }}/show">Back</a></p>
<< endblock >>