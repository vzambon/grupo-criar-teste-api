<?php

namespace App\Api\Controllers;

use Geolocations\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->searchIndex(State::class, $request);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        return $state;
    }

    /**
     * Toggle status (is_active) of specified resource.
     */
    public function toggleStatus(State $state)
    {
        $state->is_active = !$state->is_active;

        $state->save();

        return response()->json(['message' => 'State status updated successfully!']);
    }

}
