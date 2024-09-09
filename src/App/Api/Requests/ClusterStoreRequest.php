<?php

namespace App\Api\Requests;

use Geolocations\Models\City;
use Illuminate\Foundation\Http\FormRequest;
use Support\Rules\UniqueInRelation;

class ClusterStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'cities' => ['array', 'required'],
            'cities.*' => ['int', 'exists:cities,id', UniqueInRelation::make(City::class, 'cluster', 'city_id')]
        ];
    }
}