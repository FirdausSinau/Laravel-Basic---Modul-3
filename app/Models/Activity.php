<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'code',
        'title',
        'description',
        'activity_date',
        'status',
        'location',
        'capacity',
        'start_at',
        'end_at',
    ];

    /**
     * Cast atribut model ke tipe data asli.
     */
    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke Category (Task 1).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope terpadu untuk Search (code/title), Filter Kategori & Status, serta Sort (Task 2).
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // 1. Search code atau title
        $query->when($filters['search'] ?? null, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('code', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%");
            });
        });

        // 2. Filter Kategori
        $query->when($filters['category_id'] ?? null, function ($q, $categoryId) {
            $q->where('category_id', $categoryId);
        });

        // 3. Filter Status
        $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        });

        // 4. Sort Tanggal (Terbaru / Terlama)
        $query->when($filters['sort'] ?? null, function ($q, $sort) {
            if ($sort === 'oldest') {
                $q->orderBy('activity_date', 'asc');
            } else {
                $q->orderBy('activity_date', 'desc');
            }
        }, function ($q) {
            $q->orderBy('activity_date', 'desc');
        });

        return $query;
    }
}