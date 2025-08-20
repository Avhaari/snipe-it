<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetTestItemRequest;
use App\Http\Requests\AssetTestRunRequest;
use App\Models\Asset;
use App\Models\AssetTestItem;
use App\Models\AssetTestRun;
use Illuminate\Http\Request;

class AssetTestRunsController extends Controller
{
    public function index(Asset $asset)
    {
        $this->authorize('viewAny', AssetTestRun::class);
        return response()->json($asset->testRuns()->with('items')->latest()->get());
    }

    public function store(AssetTestRunRequest $request, Asset $asset)
    {
        $this->authorize('create', AssetTestRun::class);
        $run = $asset->testRuns()->create([
            'user_id' => auth()->id(),
            'test_type' => $request->test_type,
            'status' => $request->status ?? 'in_progress',
            'os_version' => $request->os_version,
            'notes' => $request->notes,
            'started_at' => now(),
            'finished_at' => $request->finished_at,
        ]);
        return response()->json($run, 201);
    }

    public function show(AssetTestRun $run)
    {
        $this->authorize('view', $run);
        return response()->json($run->load('items'));
    }

    public function update(AssetTestRunRequest $request, AssetTestRun $run)
    {
        $this->authorize('update', $run);
        $run->update($request->safe()->except('started_at'));
        return response()->json($run);
    }

    public function destroy(AssetTestRun $run)
    {
        $this->authorize('delete', $run);
        $run->delete();
        return response()->json([], 204);
    }

    public function items(AssetTestRun $run)
    {
        $this->authorize('view', $run);
        return response()->json($run->items);
    }

    public function storeItem(AssetTestItemRequest $request, AssetTestRun $run)
    {
        $this->authorize('update', $run);
        $item = $run->items()->create($request->validated());
        return response()->json($item, 201);
    }

    public function updateItem(AssetTestItemRequest $request, AssetTestRun $run, AssetTestItem $item)
    {
        $this->authorize('update', $run);
        $item->update($request->validated());
        return response()->json($item);
    }
}
