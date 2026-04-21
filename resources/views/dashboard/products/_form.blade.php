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
    <label for="">Product Name</label>
    <input
        type="text"
        name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $product -> name) }}"
        required
        >
</div>
<div class="form-group">
    <label for="">Category</label>
    <select
        name="category_id"
        class="form-control form-select @error('category_id') is-invalid @enderror"
        required
        >
        <option value="">--Select Category--</option>
        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected(old('category_id', $product -> category_id) == $category -> id)
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
        class="form-control @error('ingredients') is-invalid @enderror"
        required
        >{{ old('ingredients', $product -> ingredients) }}</textarea>
</div>
<div class="form-group">
    <label for="">Price</label>
    <input
        type="number"
        name="price"
        class="form-control @error('price') is-invalid @enderror"
        value="{{ old('price', $product -> price) }}"
        required
        >
</div>
<div class="form-group">
    <label for="">Quantity</label>
    <input
        type="number"
        name="quantity"
        class="form-control @error('quantity') is-invalid @enderror"
        value="{{ old('quantity', $product -> quantity) }}"
        placeholder="---"
        required
        >
</div>
<div class="form-group">
    <label for="">Is_Available</label>
    <select
        name="is_available"
        class="form-control @error('is_available') is-invalid @enderror"
        required
        >
        <option value="1" @selected(old('is_available', $product -> is_available) == 1)>True</option>
        <option value="0" @selected(old('is_available', $product -> is_available) == 0)>False</option>
    </select>
</div>
<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
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
