<?php

namespace Tests\Unit;

use App\Models\Role;
use PHPUnit\Framework\TestCase;

class UserTest extends \Tests\TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserRegister()
    {
        $userData = $this->getRandomUser('customer');
        $response = $this->post('/api/auth/register', $userData);

        $response
            ->assertStatus(200)
            ->assertJson([
                'status' => 'created',
            ]);
    }

    public function testCustomerLogin()
    {
        $userData = $this->getRandomUser('customer');
        $userRegisteredResponse = $this->post('/api/auth/register', $userData);

        $userLogInResponse = $this->post('/api/auth/login', [
            'email' => $userData['email'],
            'password' => $userData['password'],
        ]);

        $userRegisteredResponse
            ->assertStatus(200)
            ->assertJson([
                'status' => 'created',
            ]);

        $userLogInResponse->assertStatus(200)
            ->assertJson([
                'status' => 'logged_in',
            ]);
    }
}
