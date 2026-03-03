<?php

use App\Models\User;

test('logs an user', function () {
    Event::fake();

    $user = User::factory()->create([ // assumes RefreshDatabase trait is used on Pest.php...
        'email' => 'nuno@laravel.com',
        'password' => 'password',
    ]);

    visit('/login')
        ->fill('#email', $user->email)
        ->fill('#password', 'password')
        ->press('@login-button')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

});

test('logs out user', function () {
    Event::fake();

    $user = User::factory()->create(); // assumes RefreshDatabase trait is used on Pest.php...

    $this->actingAs($user); // assumes RefreshDatabase trait is used on Pest.php...

    visit('/')
        ->press('@logout-button')
        ->assertPathIs('/login');

    $this->assertGuest();

});
