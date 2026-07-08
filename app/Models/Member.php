<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'membership_no', 'first_name', 'last_name',
        'email', 'phone', 'address', 'join_date', 'status',
    ];

    protected $casts = [
        'join_date'  => 'date',
        'created_at' => 'datetime',
    ];

    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class, 'member_id');
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class, 'member_id');
    }

    public function fullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
