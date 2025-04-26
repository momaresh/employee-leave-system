<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

test('leave summary pdf route works', function () {
    $admin = User::factory()->create(['role' => 'Admin']);
    $this->actingAs($admin);

    $response = $this->get(route('reports.leave-summary.pdf'));
    $response->assertStatus(200);
    // Or 302 if it redirects to download
});
