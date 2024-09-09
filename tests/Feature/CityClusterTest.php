<?php

namespace Tests\Feature;

use Geolocations\Models\City;
use Geolocations\Models\Cluster;
use Geolocations\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityClusterTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_can_list_clusters()
    {
        Cluster::factory()->has(City::factory(5)->for(State::factory()))->count(5)->create();
        
        $response = $this->get(route('clusters.index'));

        $response->assertOk()->assertJsonCount(5);
    }

    public function test_can_create_cluster()
    {
        $cities = City::factory(5)->for(State::factory())->create();

        $payload = [
            'name' => $this->faker->name,
            'cities' => $cities->pluck('id')->toArray(),
        ];

        $response = $this->post(route('clusters.store'), $payload);
        $response->assertOk();

        $this->assertDatabaseCount((new Cluster())->getTable(), 1);
        $cities->each(fn($el) => $this->assertDatabaseHas((new City)->getTable(), $el->toArray()));
    }

    public function test_city_can_be_added_to_only_one_cluster()
    {
        $cluster = Cluster::factory()->has(City::factory(5)->for(State::factory()))->create();

        $forbiddenCityId = $cluster->cities()->first()->id;

        $cities = City::factory(5)->for(State::factory())->create()->pluck('id')->push($forbiddenCityId);
        $payload = [
            'name' => $this->faker->name,
            'cities' => $cities->toArray(),
        ];

        $response = $this->post(route('clusters.store'), $payload);
        $response->assertInvalid('cities.'.$cities->count()-1);
    }

    public function test_cluster_can_be_shown()
    {
        $cluster = Cluster::factory()->create();

        $response = $this->getJson(route('clusters.show', ['cluster' => $cluster->id]));

        $response->assertOk();
        $response->assertJson($cluster->toArray());

        $table = (new Cluster())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $cluster->toArray());
    }

    public function test_can_toggle_cluster_status()
    {
        $clusterTrue = Cluster::factory()->state(['is_active' => true])->create();
        $clusterFalse = Cluster::factory()->state(['is_active' => false])->create();

        $response1 = $this->patch(route('clusters.toggle-status', ['cluster' => $clusterTrue->id]));
        $response2 = $this->patch(route('clusters.toggle-status', ['cluster' => $clusterFalse->id]));

        $response1->assertOk();
        $response2->assertOk();

        $table = (new Cluster)->getTable();
        $this->assertDatabaseCount($table, 2);
        $this->assertDatabaseHas($table, [
            'id' => $clusterTrue->id,
            'is_active' => false
        ]);
        $this->assertDatabaseHas($table, [
            'id' => $clusterFalse->id,
            'is_active' => true
        ]);
    }

    public function test_can_delete_cluster()
    {
        $cluster = Cluster::factory()->create();

        $response = $this->delete(route('clusters.destroy', ['id' => $cluster->id]));

        $response->assertOk();

        $this->assertDatabaseEmpty((new Cluster)->getTable());
    }

}
