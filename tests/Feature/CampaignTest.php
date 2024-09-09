<?php

namespace Tests\Feature;

use Campaigns\Models\Campaign;
use Geolocations\Models\City;
use Geolocations\Models\Cluster;
use Geolocations\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Products\Models\Product;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_list_campaigns()
    {
        $campaigns = Campaign::factory(10)
            ->has(Product::factory(3))
            ->has(Cluster::factory()->has(City::factory(5)->for(State::factory())))
            ->create();

        $response = $this->get(route('campaigns.index'));

        $response->assertOk();

        $this->assertEquals($response->collect()->count(), $campaigns->count());
    }

    public function test_can_create_campaign()
    {
        $clusters = Cluster::factory(5)->has(City::factory(5)->for(State::factory()))->create();

        $payload = [
            'name' => $this->faker->name,
            'clusters' => $clusters->pluck('id')->values()->toArray(),
        ];

        $response = $this->post(route('campaigns.store'), $payload);

        $response->assertOk();

        $table = (new Campaign())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, [
            'name' => $payload['name']
        ]);
    }

    public function test_cluster_can_have_only_one_active_campaign()
    {
        Campaign::factory()
            ->has(Product::factory(3))
            ->has(Cluster::factory()->state(['id' => 1])->has(City::factory(5)->for(State::factory())))
            ->create();

        $payload = [
            'name' => $this->faker->name,
            'clusters' => [1],
        ];

        $response = $this->post(route('campaigns.store'), $payload);

        $response->assertOk();

        $table = (new Campaign())->getTable();
        $this->assertDatabaseCount($table, 2);
        $this->assertCount(1, Cluster::find(1)->campaigns()->wherePivot('is_active', true)->get());
    }

    public function test_can_toggle_campaign_status()
    {
        $campaignTrue = Campaign::factory()
        ->state(['is_active' => true])
        ->create();;
        $campaignFalse = Campaign::factory()
        ->state(['is_active' => false])
        ->create();;
        
        $response1 = $this->patch(route('campaigns.toggle-status', ['campaign' => $campaignTrue->id]));
        $response2 = $this->patch(route('campaigns.toggle-status', ['campaign' => $campaignFalse->id]));

        $response1->assertOk();
        $response2->assertOk();

        $table = (new Campaign())->getTable();
        $this->assertDatabaseCount($table, 2);
        $this->assertDatabaseHas($table, [
            'id' => $campaignTrue->id,
            'is_active' => false,
        ]);
        $this->assertDatabaseHas($table, [
            'id' => $campaignFalse->id,
            'is_active' => true,
        ]);
    }

    public function test_can_delete_campaign()
    {
        $campaign = Campaign::factory()->create();;

        $response = $this->delete(route('campaigns.destroy', ['id' => $campaign->id]));

        $response->assertOk();

        $this->assertDatabaseMissing((new Campaign())->getTable(), $campaign->toArray());
    }
}
