<?php

namespace App\Actions;

use App\Models\Idea;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdateIdea
{
    /**
     * @throws Throwable
     */
    public function handle(array $attributes, Idea $idea): void
    {
        $data = collect($attributes)->only([
            'title', 'description', 'status', 'links',
        ])->toArray();

        if ($attributes['image'] ?? false) {
            $data['image_path'] = $attributes['image']->store('ideas', 'public');
        }

        DB::transaction(function () use ($data, $attributes, $idea) {
            $idea->update($data);

            $idea->steps()->delete();
            $steps = collect($attributes['steps'] ?? []);

            //            $steps = collect($attributes['steps'] ?? [])
            //                ->map(fn($step) => ['description' => $step, 'completed' => false]);
            //
            $idea->steps()->createMany($steps);

        });

    }
}
