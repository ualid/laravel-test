<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
/**
 * @group customer
 */
class CustomerTest extends TestCase
{
    use DatabaseTransactions;

    private $url = '/api/customers';
    private $user = null;

    public function setUp() :void
    {
        $credetials = [
            'email' => 'user@admin.com',
            'password' => 1234
        ];

        parent::setUp();
        $this->actingAs($credetials);
    }

    /**
      * @test
      * @group create-customer
      *
      */
    public function shouldByCreateACustomer()
    {
        $customer = $this->getCustomer();
        $response = $this->postJson($this->url, $customer);
        $response->assertStatus(200);
    }

     /**
     * @test
     * @testdox GET /api/customers
     * @group get-customer
     */
    public function shouldByReturnAllCustomer()
    {
        Customer::factory()->create();

        $response = $this->get($this->url);
        $response->assertStatus(200);
    }

     /**
     * @test
     * @testdox PUT /api/customers
     * @group update-customer
     */
    public function shouldByUpdateCustomer()
    {
        $customer = Customer::factory()->create();
        $customerData = $this->getCustomer();
        $response =  $this->put($this->url . '/' . $customer->id, $customerData);
        $response->assertStatus(200);
        $customerData['id'] = $customer->id;
        $this->assertDatabaseHas('customers', $customerData);
    }
    /**
    * @test
    * @testdox DELETE /api/customers
    * @group delete-customer
    */
   public function shouldByDeleteCustomer()
   {
       $customer = Customer::factory()->create();
       $customerData = $this->getCustomer();
       $response =  $this->delete($this->url . '/' . $customer->id, $customerData);
       $response->assertStatus(200);
       $customer->refresh();
       $this->assertNotNull($customer->deleted_at);
   }
/**
     * @test
     * @testdox POST /api/customers
     * @group create-invalid-customer
     * @dataProvider getRequiredCases
     */
    public function shouldByReturn422($case)
    {
      $this->postJson($this->url, $case)
      ->assertStatus(422);
    }
    public function getRequiredCases()
    {
        $this->refreshApplication();
        try {
            $cases = [];
            $optinalFields = collect(['status_id']);
            $requiredFields = collect((new Customer)->getFillable())
            ->filter(function ($q) use ($optinalFields) {
                return !$optinalFields->contains($q);
            })
            ->toArray();

            foreach ($requiredFields as $requiredField) {
                $customer = $this->getCustomer();

                unset($customer[$requiredField]);
                $cases["without {$requiredField}"] = [$customer];
            }

            return $cases;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

    }

    private function getCustomer() {
        return customer::factory()->make()->getAttributes();
    }
}
