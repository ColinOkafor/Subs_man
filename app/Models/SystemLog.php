<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ← add this
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;

    protected $table = '_system_logs';

    protected $fillable = [
        'user_id',
        'log_details',
    ];
    // app/Models/SystemLog.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
