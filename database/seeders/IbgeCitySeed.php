<?php

namespace Database\Seeders;

use Geolocations\Models\City;
use Geolocations\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class IbgeCitySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = State::all()->pluck('id');
        foreach ($states as $stateId) {
            $cities = [];

            if (app()->environment('production')) {
                $response = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$stateId}/municipios");

                $cities = $response->collect()->map(fn ($el) => [
                    'id' => $el['id'],
                    'name' => $el['nome'],
                    'state_id' => $stateId,
                ])->toArray();
            } else {
                $cities = City::factory(10)->make(['state_id' => $stateId])->toArray();
            }

            City::insert($cities);
        }

    }
}
