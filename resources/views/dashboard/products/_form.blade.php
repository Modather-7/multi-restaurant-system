<div class="form-group">
    <label for="">Product Name</label>
    <input
        type="text"
        name="name"
        class="form-control"
        value="{{ $product -> name ?? '' }}"
        required
        >
</div>
<div class="form-group">
    <label for="">Category</label>
    <select
        name="category_id"
        class="form-control
        form-select"
        required
        >
        <option value=""></option>
        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected($product -> category_id == $category -> id)
                >
                {{ $category->name }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="">Product Ingredients</label>
    <textarea
        name="ingredients"
        class="form-control"
        required
        >
        {{ $product -> ingredients }}
    </textarea>
</div>
<div class="form-group">
    <label for="">Price</label>
    <input
        type="number"
        name="price"
        class="form-control"
        value="{{ $product -> price }}"
        required
        >
</div>
<div class="form-group">
    <label for="">Quantity</label>
    <input
        type="number"
        name="quantity"
        class="form-control"
        value="{{ $product -> quantity }}"
        required
        >
</div>
<div class="form-group">
    <label for="">Is_Available</label>
    <select
        name="is_available"
        class="form-control"
        required
        >
        <option value="1" @selected($product -> is_available == 1)>True</option>
        <option value="0" @selected($product -> is_available == 0)>False</option>
    </select>
</div>
<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" class="form-control" accept="image/*">
    @if ($product->image)
        <img
            src="{{ asset('storage/' . $product->image) }}"
            alt=""
            height="60"
            style="border: 2px solid #ddd; padding: 3px; border-radius: 6px;"
            >
    @endif
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
