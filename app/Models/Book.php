<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';
    public $timestamps = true;

    protected $fillable = [
        'isbn', 'title', 'author', 'category_id', 'publisher',
        'published_year', 'edition', 'shelf_location', 'total_copies',
        'available_copies', 'status',
    ];

    protected $casts = [
        'total_copies'     => 'integer',
        'available_copies' => 'integer',
        'published_year'   => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'book_id');
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        $like = '%' . $term . '%';
        return $query->where(function (Builder $q) use ($like) {
            $q->where('title', 'like', $like)
              ->orWhere('author', 'like', $like)
              ->orWhere('isbn', 'like', $like);
        });
    }
}
