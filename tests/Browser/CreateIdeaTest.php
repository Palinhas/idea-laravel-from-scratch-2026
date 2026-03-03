<?php

use App\Models\User;

it('create idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('#title', 'My First Idea Pest Test')
        ->click('@idea-status-completed')
        ->fill('#description', 'This is my first idea description Test by Pest')
        ->fill('#new-link', 'https://google.com')
        ->click('@submit-new-link-button')
        ->fill('#new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->click('@button-create-idea')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea Pest Test',
        'status' => 'completed', // Completed status
        'description' => 'This is my first idea description Test by Pest',
        'links' => ['https://google.com', 'https://laravel.com'], // Links stored as JSON
    ]);

});
