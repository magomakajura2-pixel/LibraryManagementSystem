<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReturn extends Model
{
    use HasFactory;

    protected $table = 'returns';
    protected $primaryKey = 'return_id';
    public $timestamps = false;

    protected $fillable = [
        'borrowing_id', 'return_date', 'book_condition', 'received_by', 'remarks',
    ];

    protected $casts = [
        'return_date' => 'date',
        'created_at' => 'datetime',
    ];

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(Librarian::class, 'received_by');
    }
}
