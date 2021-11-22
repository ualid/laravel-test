<?php

namespace Tests\Feature;

use App\Models\Number;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
/**
 * @group number
 */
class NumberTest extends TestCase
{
    use DatabaseTransactions;
    private $url = '/api/numbers';

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
      * @group create-number-with-number-preference
      *
      */
    public function shouldByCreateANumberWithTwoNumberPreference()
    {
        $number = $this->getNumber();

        $response = $this->post($this->url, $number);
        $data = $response->getData();


        $this->assertDatabaseHas('number_preferences', [
            'number_id' => $data->id,
        ]);
    }
      /**
      * @test
      * @group create-number
      *
      */
      public function shouldByCreateANumber()
      {
          $number = $this->getNumber();
          $response = $this->post($this->url, $number);
          $response->assertStatus(200);
      }

     /**
     * @test
     * @testdox GET /api/numbers
     * @group get-number
     */
    public function shouldByReturnAllNumber()
    {
        Number::factory()->create();

        $response = $this->get($this->url);
        $response->assertStatus(200);
    }
       /**
     * @test
     * @testdox PUT /api/number
     * @group update-number
     */
    public function shouldByUpdateNumbers()
    {
        $numberPreference = Number::factory()->create();
        $numberPreferenceData = $this->getNumber();
        $response =  $this->put($this->url . '/' . $numberPreference->id, $numberPreferenceData);
        $response->assertStatus(200);
        $numberPreferenceData['id'] = $numberPreference->id;
        $this->assertDatabaseHas('numbers', $numberPreferenceData);
    }
    /**
    * @test
    * @testdox DELETE /api/number
    * @group delete-number
    */
   public function shouldByDeleteNumbers()
   {
       $numberPreference = Number::factory()->create();
       $numberPreferenceData = $this->getNumber();
       $response =  $this->delete($this->url . '/' . $numberPreference->id, $numberPreferenceData);
       $response->assertStatus(200);
       $numberPreference->refresh();
       $this->assertNotNull($numberPreference->deleted_at);
   }
/**
     * @test
     * @testdox POST /api/numbers
     * @group create-invalid-number
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
            $requiredFields = collect((new Number)->getFillable())
            ->filter(function ($q) use ($optinalFields) {
                return !$optinalFields->contains($q);
            })
            ->toArray();

            foreach ($requiredFields as $requiredField) {
                $number = $this->getNumber();

                unset($number[$requiredField]);
                $cases["without {$requiredField}"] = [$number];
            }

            return $cases;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

    }

    private function getNumber() {
        return Number::factory()->make()->getAttributes();
    }
}
