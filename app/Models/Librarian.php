<?php
// Copyright (C) 2026 KAJURA MAGOMA KAJURA — GPL v3. See LICENSE.

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Librarian extends Model
{
    use HasFactory;

    protected $primaryKey = 'librarian_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'employee_no', 'first_name', 'last_name',
        'email', 'phone', 'privilege_level', 'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fullName(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
