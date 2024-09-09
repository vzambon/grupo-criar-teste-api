<?php

namespace Tests\Feature;

use Geolocations\Models\City;
use Geolocations\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_cities()
    {
        City::factory()->for(State::factory())->count(5)->create();

        $response = $this->get(route('cities.index'));

        $response->assertOk()->assertJsonCount(5);
    }

    public function test_can_paginate_citiy()
    {
        City::factory()->for(State::factory())->count(5)->create();

        $response = $this->getJson(route('cities.index', [
            'pagination' => [
                'sortBy' => 'name',
            ],
        ]));

        $response->assertOk()
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => ['id', 'name', 'is_active', 'state_id', 'created_at', 'updated_at'],
                ],
                'sortBy',
                'descending',
            ]);
    }

    public function test_city_can_be_shown()
    {
        $city = City::factory()->for(State::factory())->create();

        $response = $this->getJson(route('cities.show', ['city' => $city->id]));

        $response->assertOk();

        $table = (new City())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $city->setHidden(['created_at', 'updated_at'])->toArray());

        $response->assertJson($city->toArray());
    }

    public function test_city_can_be_searched()
    {
        City::removeAllFromSearch();

        $cities = City::factory(10)->for(State::factory())->create();

        $cities->searchable();

        $response = $this->get(route('cities.index', [
            'search' => [
                'name' => $cities->first()->name,
            ],
        ]));

        $response->assertOk();

        $response->assertJsonFragment($cities->first()->toArray());
    }

    public function test_can_toggle_city_status()
    {
        $cityTrue = City::factory()->for(State::factory())->state(['is_active' => true])->create();
        $cityFalse = City::factory()->for(State::factory())->state(['is_active' => false])->create();

        $response1 = $this->patch(route('cities.toggle-status', ['city' => $cityTrue->id]));
        $response2 = $this->patch(route('cities.toggle-status', ['city' => $cityFalse->id]));

        $response1->assertOk();
        $response2->assertOk();

        $this->assertDatabaseCount((new City())->getTable(), 2);
        $this->assertDatabaseHas((new City())->getTable(), [
            'id' => $cityTrue->id,
            'is_active' => false,
        ]);
        $this->assertDatabaseHas((new City())->getTable(), [
            'id' => $cityFalse->id,
            'is_active' => true,
        ]);
    }
}
