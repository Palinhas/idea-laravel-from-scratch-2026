<?php

use App\Models\User;

it('create idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('#title', 'My First idea Pest Test')
        ->click('@idea-status-completed')
        ->fill('#description', 'This is my first idea description Test by Pest')
        ->fill('#new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('#new-step', 'step 1')
        ->click('@submit-new-step-button')
        ->click('@button-create-idea')
        ->assertPathIs('/ideas');

    $idea = $user->ideas()->first();

    expect($idea)
        ->not->toBeNull()
        ->toMatchArray([
            'title' => 'My First idea Pest Test',
            'status' => 'completed',
            'description' => 'This is my first idea description Test by Pest',
            'links' => ['https://laravel.com'],
        ])
        ->and($idea->steps)->toHaveCount(1);

});
