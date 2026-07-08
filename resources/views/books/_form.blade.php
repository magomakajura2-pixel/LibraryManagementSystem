<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">ISBN</label>
        <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $book->title ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Author</label>
        <input type="text" name="author" class="form-control" value="{{ old('author', $book->author ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">-- Select --</option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" {{ old('category_id', $book->category_id ?? '') == $category->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Publisher</label>
        <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $book->publisher ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Year</label>
        <input type="number" name="published_year" class="form-control" value="{{ old('published_year', $book->published_year ?? '') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Shelf</label>
        <input type="text" name="shelf_location" class="form-control" value="{{ old('shelf_location', $book->shelf_location ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Total Copies</label>
        <input type="number" name="total_copies" class="form-control" value="{{ old('total_copies', $book->total_copies ?? 1) }}" min="1" required>
    </div>
    @if(isset($book))
    <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="available" {{ old('status', $book->status) == 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ old('status', $book->status) == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
            <option value="archived" {{ old('status', $book->status) == 'archived' ? 'selected' : '' }}>Archived</option>
        </select>
    </div>
    @endif
</div>
