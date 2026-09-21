<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'activity_date',
        'status',
    ];

    public function scopeFilterStatus($query, ?string $status)
    {
        return $query->when(
            in_array($status, ['Planned', 'Ongoing', 'Done'], true),
            fn ($q) => $q->where('status', $status)
        );
    }
}
