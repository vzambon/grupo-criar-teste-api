<?php

namespace Tests\Feature;

use Geolocations\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_states()
    {
        State::factory()->count(5)->create();

        $response = $this->get(route('states.index'));

        $response->assertOk()->assertJsonCount(5);

        $this->assertDatabaseCount((new State())->getTable(), 5);
    }

    public function test_can_paginate_states()
    {
        State::factory()->count(10)->create();

        $response = $this->getJson(route('states.index', [
            'pagination' => [
                'sortBy' => 'name',
            ],
        ]));

        $response->assertOk()
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => ['id', 'name', 'acronym', 'is_active', 'created_at', 'updated_at'],
                ],
                'sortBy',
                'descending',
            ]);
    }

    public function test_state_can_be_shown()
    {
        State::removeAllFromSearch();

        $state = State::factory()->create();

        $response = $this->getJson(route('states.show', ['state' => $state->id]));

        $response->assertOk();

        $response->assertJson($state->toArray());

        $table = (new State())->getTable();
        $this->assertDatabaseCount($table, 1);
        $this->assertDatabaseHas($table, $state->setHidden(['created_at', 'updated_at'])->toArray());
    }

    public function test_state_can_be_searched()
    {
        $states = State::factory(10)->create();

        $states->searchable();

        $response = $this->get(route('states.index', [
            'search' => [
                'name' => $states->first()->name,
            ],
        ]));

        $response->assertOk();

        $response->assertJsonFragment($states->first()->toArray());
    }

    public function test_can_toggle_state_status()
    {
        $stateTrue = State::factory()->state(['is_active' => true])->create();
        $stateFalse = State::factory()->state(['is_active' => false])->create();

        $response1 = $this->patch(route('states.toggle-status', ['state' => $stateTrue->id]));
        $response2 = $this->patch(route('states.toggle-status', ['state' => $stateFalse->id]));

        $response1->assertOk();
        $response2->assertOk();

        $this->assertDatabaseCount((new state())->getTable(), 2);
        $this->assertDatabaseHas((new state())->getTable(), [
            'id' => $stateTrue->id,
            'is_active' => false,
        ]);
        $this->assertDatabaseHas((new state())->getTable(), [
            'id' => $stateFalse->id,
            'is_active' => true,
        ]);
    }
}
