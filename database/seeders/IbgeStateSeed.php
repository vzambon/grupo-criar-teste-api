<?php

namespace Database\Seeders;

use Geolocations\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class IbgeStateSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [];

        if(app()->environment('production')){
            $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
    
            $states = $response->collect()->map(fn($el) => [
                'id' => $el['id'],
                'name' => $el['nome'],
                'acronym' => $el['sigla']
            ])->toArray();
        } else{
            $states = State::factory(10)->make()->toArray();
        }

        State::insert($states);
    }
}
