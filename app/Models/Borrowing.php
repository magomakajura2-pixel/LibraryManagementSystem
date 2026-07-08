<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrowing extends Model
{
    use HasFactory;

    protected $primaryKey = 'borrowing_id';
    public $timestamps = false;

    protected $fillable = [
        'book_id', 'member_id', 'librarian_id',
        'borrow_date', 'due_date', 'status',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'due_date'    => 'date',
        'created_at'  => 'datetime',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function librarian(): BelongsTo
    {
        return $this->belongsTo(Librarian::class, 'librarian_id');
    }

    public function bookReturn(): HasOne
    {
        return $this->hasOne(BookReturn::class, 'borrowing_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereIn('status', ['borrowed', 'overdue']);
    }

    public function isOpen(): bool
    {
        return in_array($this->status, ['borrowed', 'overdue'], true);
    }
}
