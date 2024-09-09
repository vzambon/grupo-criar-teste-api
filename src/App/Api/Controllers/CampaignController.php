<?php

namespace App\Api\Controllers;

use App\Api\Requests\CampaignStoreRequest;
use Campaigns\Models\Campaign;
use Geolocations\Models\Cluster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource. Allowing Pagination and Search
     */
    public function index(Request $request)
    {
        return $this->searchIndex(Campaign::class, $request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampaignStoreRequest $request)
    {
        DB::transaction(function() use($request) {
            $campaing = Campaign::create($request->except(['clusters']));

            DB::table('cluster_campaign_pivot')->update(['is_active' => false]);

            $campaing->clusters()->syncWithoutDetaching($request->input('clusters'));        
        });
    
        return response()->json(['message' => 'Cluster created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign)
    {
        return $campaign;
    }

    /**
     * Toggle status (is_active) of specified resource.
     */
    public function toggleStatus(Campaign $campaign)
    {
        $campaign->is_active = ! $campaign->is_active;

        $campaign->save();

        return response()->json(['message' => 'Campaign status updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Campaign::where('id', $id)->delete();

        return response()->json(['message' => 'Campaig delete successfully!']);
    }
}
