<?php

namespace Tests\Feature\AssetTestRuns;

use App\Models\Asset;
use App\Models\AssetTestRun;
use App\Models\AssetTestItem;
use App\Models\Group;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssetTestRunTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config(['auth.guards.api.driver' => 'session']);
    }

    protected function createUserWithRole(string $role): User
    {
        $group = Group::create(['name' => $role]);
        $user = User::factory()->create();
        $user->groups()->attach($group);
        return $user;
    }

    public function test_refurbisher_can_create_run_and_items(): void
    {
        $user = $this->createUserWithRole('refurbisher');
        $asset = Asset::factory()->create();

        $this->actingAs($user)->post(route('hardware.test-runs.store', $asset), [
            'os_version' => '1.0',
        ])->assertRedirect();

        $run = AssetTestRun::first();
        $this->actingAs($user, 'api')->postJson('/api/v1/test-runs/'.$run->id.'/items', [
            'component' => 'keyboard',
            'status' => 'pass',
        ])->assertStatus(201);

        $this->assertTrue($run->fresh()->all_passed);
    }

    public function test_packer_cannot_create_run(): void
    {
        $user = $this->createUserWithRole('packer');
        $asset = Asset::factory()->create();

        $this->actingAs($user)->post(route('hardware.test-runs.store', $asset), [
            'os_version' => '1.0',
        ])->assertForbidden();
    }

    public function test_all_passed_false_with_fail(): void
    {
        $user = $this->createUserWithRole('refurbisher');
        $asset = Asset::factory()->create();
        $run = AssetTestRun::create([
            'asset_id' => $asset->id,
            'user_id' => $user->id,
        ]);
        AssetTestItem::create([
            'asset_test_run_id' => $run->id,
            'component' => 'keyboard',
            'status' => 'fail',
        ]);
        $this->assertFalse($run->fresh()->all_passed);
    }
}
