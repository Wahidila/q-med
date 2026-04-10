<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['queue_id', 'description', 'cost'];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }
}
