<?php

namespace App\Models;

use App\ideaStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'status' => ideaStatus::class,
    ];

    protected $attributes = [
        'status' => ideaStatus::PENDING,
        'links' => '[]',
    ];

    public static function statusCounts(User $user): Collection
    {

        $statusCounts = $user->ideas()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Garante que todos os status apareçam no array
        return collect(IdeaStatus::cases())
            ->mapWithKeys(fn($status) => [$status->value => $statusCounts[$status->value] ?? 0])
            ->put('all', $statusCounts->sum());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }
}
