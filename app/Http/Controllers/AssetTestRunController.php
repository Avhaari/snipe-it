<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssetTestRunRequest;
use App\Models\Asset;
use App\Models\AssetTestRun;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AssetTestRunController extends Controller
{
    public function index(Asset $asset)
    {
        $this->authorize('viewAny', AssetTestRun::class);
        $runs = $asset->testRuns()->with('items')->latest()->get();
        return view('hardware.test-runs.index', compact('asset', 'runs'));
    }

    public function store(AssetTestRunRequest $request, Asset $asset): RedirectResponse
    {
        $this->authorize('create', AssetTestRun::class);
        $asset->testRuns()->create([
            'user_id' => auth()->id(),
            'test_type' => $request->input('test_type'),
            'status' => $request->input('status', 'in_progress'),
            'os_version' => $request->input('os_version'),
            'notes' => $request->input('notes'),
            'started_at' => now(),
            'finished_at' => $request->input('finished_at'),
        ]);
        return redirect()->route('hardware.show', $asset);
    }

    public function update(AssetTestRunRequest $request, AssetTestRun $run): RedirectResponse
    {
        $this->authorize('update', $run);
        $run->update($request->safe()->except('started_at'));
        return redirect()->back();
    }

    public function destroy(AssetTestRun $run): RedirectResponse
    {
        $this->authorize('delete', $run);
        $run->delete();
        return redirect()->back();
    }
}
