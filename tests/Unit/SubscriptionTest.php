<?php
// tests/Unit/SubscriptionTest.php
use App\Models\User;
use App\Models\Subscription;

it('belongs to a user', function () {
    $user = User::factory()->create();
    $subscription = Subscription::factory()->create(['user_id' => $user->id]);

    expect($subscription->user)->toBeInstanceOf(User::class)
        ->and($subscription->user->id)->toBe($user->id);
});

it('stores the expected attributes', function () {
    $subscription = Subscription::factory()->create([
        'name' => 'Netflix',
        'status' => 'active',
    ]);

    $this->assertDatabaseHas('_subscriptions', [
        'name' => 'Netflix',
        'status' => 'active',
    ]);
});

it('casts dates properly', function () {
    $subscription = Subscription::factory()->create();

    expect($subscription->start_date)->toBeInstanceOf(\Illuminate\Support\Carbon::class)
        ->and($subscription->next_billing_cycle)->toBeInstanceOf(\Illuminate\Support\Carbon::class);
});

it('is deleted when its user is deleted', function () {
    $user = User::factory()->create();
    $subscription = Subscription::factory()->create(['user_id' => $user->id]);

    $user->delete();

    $this->assertDatabaseMissing('_subscriptions', ['id' => $subscription->id]);
});