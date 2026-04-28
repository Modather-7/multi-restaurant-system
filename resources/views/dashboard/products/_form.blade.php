@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Error Occured</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form.label id="name">Product Name</x-form.label>
    <x-form.input name="name" :value="$product -> name" />
</div>

<div class="form-group">
    <x-form.label id="category">Category</x-form.label>
    <x-form.select name="category_id" :options="$categories->pluck('name','id')" :selected="$product -> category_id"
    placeholder="--Select Category--"/>
</div>

<div class="form-group">
    <x-form.label id="name">Ingredients</x-form.label>
    <x-form.textarea  name="ingredients" :value="$product -> ingredients" />
</div>

<div class="form-group">
    <x-form.label id="price">Price</x-form.label>
    <x-form.input name="price" type="number" :value="$product -> price" label="Price" placeholder="Add Price" />
</div>

<div class="form-group">
    <x-form.label id="quantity">Quantity</x-form.label>
    <x-form.input name="quantity" type="number" :value="$product -> quantity" label="Quantity" placeholder="Add Quantity"/>
</div>

<div class="form-group">
    <x-form.label id="is_available">Is_Available</x-form.label>
    <x-form.select name="is_available" :options="[1 => 'True', 0 => 'False']" :selected="$product -> is_available" />
</div>

<div class="form-group">
    <x-form.label id="Image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($product->image)
        <img
            src="{{ asset('storage/' . $product -> image) }}"
            alt=""
            height="60"
            style="border: 2px solid #ddd; padding: 3px; border-radius: 6px;"
            >
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
