<?php
// app/Models/Subscription.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = '_subscriptions';

    protected $fillable = [
        'user_id',
        'name',
        'amount',
        'status',
        'billing_cycle',
        'start_date',
        'next_billing_cycle',
        'short_note',
        'category',
    ];

    protected $casts = [
        'amount' => 'decimal:2', // safer than float for money
        'start_date' => 'date',
        'next_billing_cycle' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
