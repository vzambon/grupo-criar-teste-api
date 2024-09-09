<?php

namespace App\Api\Controllers;

use Geolocations\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource. Allowing Pagination and Search
     */
    public function index(Request $request)
    {
        return $this->searchIndex(City::class, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return $city;
    }

    /**
     * Toggle status (is_active) of specified resource.
     */
    public function toggleStatus(City $city)
    {
        $city->is_active = !$city->is_active;

        $city->save();

        return response()->json(['message' => 'City status updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
