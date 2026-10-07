<?php
// tests/Unit/UserTest.php
use App\Models\User;
use App\Models\Subscription; // ← add this alongside your existing `use App\Models\User;`
it('can be created with a factory', function () {
    $user = User::factory()->create(['email' => 'test@example.com']);

    expect($user->email)->toBe('test@example.com');
    $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
});

it('hashes the password automatically', function () {
    $user = User::factory()->create(['password' => 'plain-text-password']);

    expect($user->password)->not->toBe('plain-text-password');
});

it('requires a unique email', function () {
    User::factory()->create(['email' => 'duplicate@example.com']);

    expect(fn () => User::factory()->create(['email' => 'duplicate@example.com']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});
it('can have many subscriptions', function () {
    $user = User::factory()->create();
    Subscription::factory()->count(3)->create(['user_id' => $user->id]);

    expect($user->subscriptions)->toHaveCount(3);
});