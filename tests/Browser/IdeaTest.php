<?php

use App\Models\Idea;
use App\Models\User;

it('create idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('#title', 'My First idea Pest Test')
        ->click('@idea-status-completed')
        ->fill('#description', 'This is my first idea description Test by Pest')
        ->fill('#new-link', 'https://google.com')
        ->click('@submit-new-link-button')
        ->fill('#new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('#new-step', 'step 1')
        ->click('@submit-new-step-button')
        ->fill('#new-step', 'step 2')
        ->click('@submit-new-step-button')
        ->click('@button-create-idea')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'My First idea Pest Test',
        'status' => 'completed', // Completed status
        'description' => 'This is my first idea description Test by Pest',
        'links' => ['https://google.com', 'https://laravel.com'], // Links stored as JSON
    ])->and($idea->steps)->toHaveCount(2);

});

it('edit an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('#title', 'My First idea Pest Test')
        ->click('@idea-status-completed')
        ->fill('#description', 'This is my first idea description Test by Pest')
        ->fill('#new-link', 'https://google.com')
        ->click('@submit-new-link-button')
        ->fill('#new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('#new-step', 'step 1')
        ->click('@submit-new-step-button')
        ->fill('#new-step', 'step 2')
        ->click('@submit-new-step-button')
        ->click('@button-create-idea')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'My First idea Pest Test',
        'status' => 'completed', // Completed status
        'description' => 'This is my first idea description Test by Pest',
        'links' => ['https://google.com', 'https://laravel.com'], // Links stored as JSON
    ]);

    expect($idea->steps)->toHaveCount(2);

});
