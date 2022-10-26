<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ExchangeRateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExchangeRateTest extends TestCase
{
    use RefreshDatabase;

    private $dataUser = null;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->dataUser = $this->login();
    }

    public function test_success_login()
    {
        // get login
        $data = $this->login();

        // Verify token presence
        $this->assertArrayHasKey('token', $data["data"]);
    }


    /**
     * Test a failing login
     */
    public function test_failed_login()
    {
        // request authentication
        $response = $this->post('/api/login', [
            'email' => "test@test.com",
            'password' => 'password',
        ]);

        $response = json_decode($response->getContent(), true);

        // verify invalid login details messages
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals($response["message"], "Invalid login details.");
    }

    public function login()
    {
        // create user
        $user = User::factory()->create();

        // request authentication
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $response->assertStatus(200);

        return json_decode($response->getContent(), true);
    }

    /**
     * Return a successful rate
     */
    public function test_get_exchange_rate_success()
    {
        // populate database with seeder
        $this->seed(ExchangeRateSeeder::class);

        // request token validation and returned data from database
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->dataUser["data"]["token"])
            ->post('/api/exchange-rate', [
            'from_currency' => 'GBP',
            'to_currency' => 'EUR',
            'amount' => '50.00'
        ]);

        $responseToArray =  json_decode($response->getContent(), true);

        $this->assertArrayHasKey("data", $responseToArray);
        $this->assertArrayHasKey("message", $responseToArray);
        $this->assertArrayHasKey("amount_exchanged", $responseToArray["data"]);
        $this->assertArrayHasKey("from_currency", $responseToArray["data"]);
        $this->assertArrayHasKey("to_currency", $responseToArray["data"]);
        $this->assertArrayHasKey("amount_to_exchange", $responseToArray["data"]);
        $this->assertEquals($responseToArray["message"], "success");
        $response->assertStatus(200);
    }

    /**
     * Return an unsuccesful result entering wrong data
     */
    public function test_get_exchange_rate_unsuccessfull()
    {
        $this->seed(ExchangeRateSeeder::class);

        // request authentication
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->dataUser["data"]["token"])
            ->post('/api/exchange-rate', [
                'amount' => '50.00'
            ]);

        $responseToArray =  json_decode($response->getContent(), true);
        $this->assertArrayHasKey("from_currency", $responseToArray["data"]);
        $this->assertArrayHasKey("to_currency", $responseToArray["data"]);
        $this->assertArrayHasKey("message", $responseToArray);
        $this->assertEquals("Validation failed", $responseToArray["message"]);
        $this->assertEquals("The from currency field is required.", $responseToArray["data"]["from_currency"][0]);
        $this->assertEquals("The to currency field is required.", $responseToArray["data"]["to_currency"][0]);
        $response->assertStatus(200);
    }
}
