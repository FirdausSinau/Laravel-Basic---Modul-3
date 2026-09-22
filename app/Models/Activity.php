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

    /**
     * Cast atribut model ke tipe data asli.
     */
    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    /**
     * Scope kueri untuk memfilter kegiatan berdasarkan status yang valid.
     */
    public function scopeFilterStatus($query, ?string $status)
    {
        return $query->when(
            in_array($status, ['Planned', 'Ongoing', 'Done'], true),
            fn ($q) => $q->where('status', $status)
        );
    }
}
