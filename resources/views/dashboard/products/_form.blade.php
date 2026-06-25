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
    <x-form.label id="restaurant">Restaurant</x-form.label>
    <x-form.select name="restaurant_id" :options="$restaurants->pluck('name','id')" :selected="$product -> restaurant_id"
    placeholder="--Select Restautant--"/> {{-- This is experimental system not final edition --}}
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
    <x-form.label id="status">Status</x-form.label>
    <x-form.radio name="status"
    :options="[
        'active' => 'Active',
        'draft' => 'Draft',
        'archived' => 'Archived',
    ]"
    :checked="$product -> status" />
</div>

<div class="form-group">
    <x-form.label id="branches">Available in Branch</x-form.label>

    @foreach ($branches as $branch)
        <div class="form-check">
            <input
                type="checkbox"
                class="form-check-input"
                name="branches[]"
                value="{{ $branch->id }}"
                @checked($product->exists && $product->branches->contains($branch->id))
            >
            {{ $branch->name }}
        </div>
    @endforeach
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
