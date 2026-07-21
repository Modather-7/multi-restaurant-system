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
    <x-form.label id="name">Category Name</x-form.label>
    <x-form.input name="name" :value="$category -> name" />
</div>

<div class="form-group">
    <x-form.label id="restaurant">Restaurant</x-form.label>
    <x-form.select name="restaurant_id" :options="$restaurants->pluck('name','id')" :selected="$category -> restaurant_id"
    placeholder="--Select Restautant--"/> {{-- This is experimental system not final edition --}}
</div>

<div class="form-group">
    <x-form.label id="Image">Image</x-form.label>
    <x-form.input type="file" name="image" accept="image/*" />
    @if ($category->image)
        <img
            src="{{ asset('storage/' . $category -> image) }}"
            alt=""
            height="60"
            style="border: 2px solid #ddd; padding: 3px; border-radius: 6px;"
            >
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
