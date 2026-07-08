<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fine extends Model
{
    use HasFactory;

    protected $primaryKey = 'fine_id';
    public $timestamps = false;

    protected $fillable = [
        'borrowing_id', 'member_id', 'amount',
        'reason', 'status', 'issued_date', 'paid_date',
    ];

    protected $casts = [
        'amount'      => 'float',
        'issued_date' => 'date',
        'paid_date'   => 'date',
    ];

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
