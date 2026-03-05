<?php

use App\Models\Idea;
use App\Models\User;

it('updated an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('#title', 'My First idea Pest Test')
        ->click('@idea-status-completed')
        ->fill('#description', 'This is my first idea description Test by Pest')
        ->fill('#new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('#new-step', 'step 1')
        ->click('@submit-new-step-button')
        ->click('@button-edit-idea')
        ->assertRoute('idea.show', [$idea]);

    $idea->refresh();

    expect($idea)
        ->toMatchArray([
            'title' => 'My First idea Pest Test',
            'status' => 'completed',
            'description' => 'This is my first idea description Test by Pest',
            'links' => [$idea->links[0], 'https://laravel.com'],
        ])
        ->and($idea->steps)->toHaveCount(1);

});
