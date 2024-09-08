<?php

namespace Geolocations\Http\Controllers;

use App\Http\Controllers\Controller;
use Geolocations\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource. Allowing Pagination and Search
     */
    public function index(Request $request)
    {
        $pagination = $request->input('pagination');

        $select = $request->input('select');

        $search = $request->input('search', []);

        $query = City::query();

        if ($select) {
            $query->select(explode(',', $select));
        }

        $searchTermKeys = [];
        foreach ($search as $key => $value) {
            if (collect(City::getSearchable())->contains($key)) {
                $searchTermKeys[] = $key;
                continue;
            }

            $query->where($key, $value);
        }

        if (! empty($searchTermKeys)) {
            $query->searchByFields($searchTermKeys, collect($searchTermKeys)->map(fn ($el) => $request->input($el))->toArray());
        }

        if($pagination){
            if ($pagination['sortBy'] ?? false) {
                $desc = filter_var($pagination['descending'] ?? 'false', FILTER_VALIDATE_BOOLEAN) ?? false;
                $query->orderBy($pagination['sortBy'], $desc ? 'desc' : 'asc');
            }
    
            $response = $query->paginate($pagination['rowsPerPage'] ?? null, ['*'], 'page', $pagination['page'] ?? null)->toArray();
    
            if ($pagination['sortBy'] ?? false) {
                $response['sortBy'] = $pagination['sortBy'] ?? 'id';
                $response['descending'] = filter_var($pagination['descending'] ?? 'false', FILTER_VALIDATE_BOOLEAN);
            }

            return $response;
        }

        return $query->get();
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return $city;
    }

    /**
     * Update the specified resource in storage.
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
