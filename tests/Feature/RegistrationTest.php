<?php

use function Pest\Laravel\post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class); // <-- Moved here to the test file

it('rejects passwords that do not meet complexity requirements', function (string $invalidPassword) {
    // Act: Attempt to register with the invalid password
    $response = post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => $invalidPassword,
        'password_confirmation' => $invalidPassword,
    ]);
   
    $response->assertInvalid(['password']);
    
})->with([
    'too short' => ['short'],                          // Fails min(8)
    'no uppercase' => ['alllowercase123!'],            // Fails mixedCase()
    'no lowercase' => ['ALLLOWERCASE123!'],            // Fails mixedCase()
    'no numbers' => ['NoNumbersHere!'],                // Fails numbers()
    'no symbols' => ['NoSymbols123456'],               // Fails symbols()
]);


it('accepts a password that meets all complexity requirements', function () {
    $response = post('/register', [
        'name' => 'Valid User',
        'email' => 'valid@example.com',
        'password' => 'Strong!Pass123',
        'password_confirmation' => 'Strong!Pass123',
    ]);

    // Assert: There are no validation errors for the password
    $response->assertValid(['password']);
    
    // Depending on your controller, you might also assert a redirect
    // $response->assertRedirect('/dashboard');
});