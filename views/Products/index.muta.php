<< extends "base" >>
<< block title >>Products<< endblock >>
<< block body >>
<h1>Product List</h1>
<a href="/products/create">Create Product</a>
<< foreach ($products as $product): >>
    <div>
        <h2>
            <a href="/products/{{ product['id'] }}/show">
                {{ product['name'] }}
            </a>
        </h2>
    </div>
<< endforeach; >>
<< endblock >>