<?php

use App\Models\Idea;
use App\Models\User;

it('create idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('#title', 'My First Idea Pest Test')
        ->click('@idea-status-completed')
        ->fill('#description', 'This is my first idea description Test by Pest')
        ->click('@button-create-idea')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'My First Idea Pest Test',
        'status' => 'completed', // Completed status
        'description' => 'This is my first idea description Test by Pest',
    ]);

});
