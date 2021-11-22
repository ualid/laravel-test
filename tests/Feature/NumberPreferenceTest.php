<?php

namespace Tests\Feature;

use App\Models\NumberPreference;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
/**
 * @group number-preference
 */
class NumberPreferenceTest extends TestCase
{
    use DatabaseTransactions;
    private $url = '/api/number-preferences';

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
      * @group create-number-preference
      *
      */
    public function shouldByCreateANumberPreference()
    {
        $numberPreference = $this->getNumberPreference();
        $response = $this->postJson($this->url, $numberPreference);
        $response->assertStatus(200);
    }

     /**
     * @test
     * @testdox GET /api/number-preferences
     * @group get-number-preference
     */
    public function shouldByReturnAllNumberPreference()
    {
        NumberPreference::factory()->create();

        $response = $this->get($this->url);
        $response->assertStatus(200);
    }
     /**
     * @test
     * @testdox PUT /api/number-preferences
     * @group update-number-preferences
     */
    public function shouldByUpdateNumberPreferences()
    {
        $numberPreference = NumberPreference::factory()->create();
        $numberPreferenceData = $this->getNumberPreference();
        $response =  $this->put($this->url . '/' . $numberPreference->id, $numberPreferenceData);
        $response->assertStatus(200);
        $numberPreferenceData['id'] = $numberPreference->id;
        $this->assertDatabaseHas('number_preferences', $numberPreferenceData);
    }
    /**
    * @test
    * @testdox DELETE /api/number-preferences
    * @group delete-number-preferences
    */
   public function shouldByDeleteNumberPreferences()
   {
       $numberPreference = NumberPreference::factory()->create();
       $numberPreferenceData = $this->getNumberPreference();
       $response =  $this->delete($this->url . '/' . $numberPreference->id, $numberPreferenceData);
       $response->assertStatus(200);
       $numberPreference->refresh();
       $this->assertNotNull($numberPreference->deleted_at);
   }
    /**
     * @test
     * @testdox POST /api/number-preferences
     * @group create-invalid-number-preference
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
            $optinalFields = collect([]);
            $requiredFields = collect((new NumberPreference)->getFillable())
            ->filter(function ($q) use ($optinalFields) {
                return !$optinalFields->contains($q);
            })
            ->toArray();

            foreach ($requiredFields as $requiredField) {
                $numberPreference = $this->getNumberPreference();

                unset($numberPreference[$requiredField]);
                $cases["without {$requiredField}"] = [$numberPreference];
            }

            return $cases;
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }

    }

    private function getNumberPreference() {
        return NumberPreference::factory()->make()->getAttributes();
    }
}
