<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_id';
    public $timestamps = false;

    protected $fillable = [
        'actor', 'action', 'table_name', 'record_id', 'details', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
