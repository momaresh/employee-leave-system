<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LeaveRequestSummaryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_leave_summary_pdf_route_works()
    {
        $admin = User::factory()->create(['role' => 'Admin']);
        $this->actingAs($admin);

        $response = $this->get(route('reports.leave-summary.pdf'));
        $response->assertStatus(200); // Or 302 if it redirects to download
    }
}
