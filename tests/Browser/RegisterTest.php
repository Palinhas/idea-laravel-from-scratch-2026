<?php

test('register a user', function () {
    visit('/register')
        ->fill('#name', 'John Doe')
        ->fill('#email', 'nuno@laravel.com')
        ->fill('#password', 'password')
        ->press('Create Account')
        ->assertPathIs('/');

    $this->assertAuthenticated();
    expect(Auth::user())->toMatchArray([
        'name' => 'John Doe',
        'email' => 'nuno@laravel.com',
    ]);
});

test('requires a valid email', function () {
    visit('/register')
        ->fill('#name', 'John Doe')
        ->fill('#email', 'nuno123')
        ->fill('#password', 'password')
//        ->debug();
        ->press('Create Account')
        ->assertPathIs('/register');
});
