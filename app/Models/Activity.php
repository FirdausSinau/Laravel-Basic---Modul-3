<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
    // 1. Pencarian teks pada kolom title
    $query->when($filters['search'] ?? null, function ($query, $search) {
        $query->where('title', 'like', '%' . $search . '%');
    });

    // 2. Filter berdasarkan category_id
    $query->when($filters['category_id'] ?? null, function ($query, $categoryId) {
        $query->where('category_id', $categoryId);
    });

    // 3. Filter berdasarkan status
    $query->when($filters['status'] ?? null, function ($query, $status) {
        $query->where('status', $status);
    });

    // 4. Pengurutan data (sort)
    $query->when($filters['sort'] ?? null, function ($query, $sort) {
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }
    }, function ($query) {
        // Default sort jika parameter kosong
        $query->orderBy('created_at', 'desc');
    });

    return $query;
}
}
