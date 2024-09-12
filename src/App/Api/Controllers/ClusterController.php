<?php

namespace App\Api\Controllers;

use App\Api\Requests\ClusterStoreRequest;
use Geolocations\Models\Cluster;
use Illuminate\Support\Facades\Cache;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Cluster::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClusterStoreRequest $request)
    {
        $cluster = Cluster::create($request->except(['cities']));

        $cluster->cities()->attach($request->input('cities'));

        return response()->json(['message' => 'Cluster created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cluster $cluster)
    {
        return $cluster;
    }

    /**
     * Toggle status (is_active) of specified resource.
     */
    public function toggleStatus(Cluster $cluster)
    {
        $cluster->is_active = ! $cluster->is_active;

        $cluster->save();

        return response()->json(['message' => 'Cluster status updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cluster::where('id', $id)->delete();

        return response()->json(['message' => 'Cluster deleted successfully!']);
    }

    public function showCampaign(Cluster $cluster)
    {
        return $cluster->active_campaign;
    }
}
