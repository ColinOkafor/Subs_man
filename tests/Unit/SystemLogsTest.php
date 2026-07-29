<?php
// tests/Unit/SystemLogsTest.php
use App\Models\User;
use App\Models\SystemLog;

it('can be created and linked to a user', function () {
    $user = User::factory()->create();

    $log = SystemLog::factory()->create([
        'user_id' => $user->id,
        'log_details' => 'User logged in',
    ]);

    expect($log->log_details)->toBe('User logged in');
    $this->assertDatabaseHas('_system_logs', [
        'user_id' => $user->id,
        'log_details' => 'User logged in',
    ]);
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $log = SystemLog::factory()->create(['user_id' => $user->id]);

    expect($log->user)->toBeInstanceOf(User::class)
        ->and($log->user->id)->toBe($user->id);
});

it('is deleted when its user is deleted', function () {
    $user = User::factory()->create();
    $log = SystemLog::factory()->create(['user_id' => $user->id]);

    $user->delete();

    $this->assertDatabaseMissing('_system_logs', ['id' => $log->id]);
});