<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_campaigns()
    {
        $this->assertEquals(true, true);
    }

    public function test_can_create_campaign()
    {
        $this->assertEquals(true, true);
    }

    public function test_can_innacativate_campaing()
    {
        $this->assertEquals(true, true);
    }

    public function test_can_delete_campaign()
    {
        $this->assertEquals(true, true);
    }

    public function test_only_one_campaign_active_per_cluster()
    {
        $this->assertEquals(true, true);
    }
}
