<?php

use App\Models\User;
use App\Notifications\EmailChanged;
use Illuminate\Auth\Notifications\VerifyEmail;

it('require authentication', function () {
    visit(route('profile.edit'))->assertPathIs('/login');
});

it('edit profile', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    visit(route('profile.edit'))
        ->assertValue('name', $user->name)
        ->fill('name', 'new name')
        ->assertValue('email', $user->email)
        ->fill('email', 'test@email.com')
        ->click('Update Account')
        ->assertSee('Profile updated successfully.');

    expect($user->fresh())->toMatchArray(['name' => 'new name',
        'email' => 'test@email.com']);
});

it(
/**
 * @throws Exception
 */
    'notifies the original email if change', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Notification::fake();

    $originalEmail = $user->email;

    visit(route('profile.edit'))
        ->assertValue('email', $user->email)
        ->fill('email', 'test@email.com')
        ->click('Update Account')
        ->assertSee('Profile updated successfully.');

    Notification::assertSentOnDemand(EmailChanged::class, function (EmailChanged $notification, $routes, $notifiable) use ($originalEmail) {
        return $notifiable->routes['mail'] === $originalEmail;
    });
});
