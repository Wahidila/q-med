<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'queue_number', 'queue_date', 'status', 'called_at'];

    protected $casts = [
        'queue_date' => 'date',
        'called_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }

    public function scopeToday($query)
    {
        return $query->where('queue_date', now()->toDateString());
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }

    public function scopeCalled($query)
    {
        return $query->where('status', 'called');
    }

    public function scopeServing($query)
    {
        return $query->where('status', 'serving');
    }

    public static function getNextNumber(): int
    {
        $maxNumber = static::today()->max('queue_number');
        return ($maxNumber ?? 0) + 1;
    }
}
