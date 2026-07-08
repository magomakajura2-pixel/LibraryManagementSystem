<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservation_id';
    public $timestamps = false;

    protected $fillable = [
        'book_id', 'member_id', 'reserved_date', 'expiry_date', 'status',
    ];

    protected $casts = [
        'reserved_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
