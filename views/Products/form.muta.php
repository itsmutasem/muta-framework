<input type="hidden" name="csrf_token" value="{{ csrf_token }}">

<label for="name">Name</label>
<input type="text" name="name" id="name" value="{{ product['name'] }}">
<< if(!empty($errors['name'][0])) : >>
    <p>{{ errors['name'][0] }}</p>
<< endif; >>

<label for="description">Description</label>
<textarea name="description" id="description" cols="30" rows="10">{{ product['description'] }}</textarea>
<< if(!empty($errors['description'][0])) : >>
<p>{{ errors['description'][0] }}</p>
<< endif; >>

<button type="submit">Save</button>