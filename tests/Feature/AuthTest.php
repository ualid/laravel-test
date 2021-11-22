<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @group auth
 */
class AuthTest extends TestCase
{
    use DatabaseTransactions;
    private $url = '/api/login';

      /**
     * @test
     * @testdox POST /api/login
     * @group auth-login
     */
    public function shouldByLogin()
    {
        $credentials = [
            'email' => 'user@admin.com',
            'password' => 1234,
        ];

        $response = $this->post($this->url, $credentials);
        $response->assertStatus(200);
    }

    /**
     * @test
     * @testdox POST /api/login
     * @group auth-login-invalid
     */
    public function shouldByReceiveInvalidMessage()
    {
        $credentials = [
            'email' => 'user-invalid@admin.com',
            'password' => 123456,
        ];

        $response = $this->post($this->url, $credentials);
        $response->assertStatus(401);
    }
}
