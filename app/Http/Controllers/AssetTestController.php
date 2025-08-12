<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetTest;
use Illuminate\Http\Request;

class AssetTestController extends Controller
{
    public function index(Asset $asset)
    {
        $tests = $asset->tests()->latest('tested_at')->get();

        // Derive quick “failed components” list for UI
        $failed = $asset->tests()
            ->where('result','fail')
            ->latest('tested_at')
            ->get()
            ->groupBy('component')
            ->keys();

        return view('hardware.tests.index', compact('asset','tests','failed'));
    }

    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'component' => 'required|string|max:255',
            'result'    => 'required|in:pass,fail,n_a',
            'comment'   => 'nullable|string|max:2000',
            'tested_at' => 'nullable|date',
        ]);

        $asset->tests()->create([
            'user_id'   => optional($request->user())->id,
            'component' => $validated['component'],
            'result'    => $validated['result'],
            'comment'   => $validated['comment'] ?? null,
            'tested_at' => $validated['tested_at'] ?? now(),
        ]);

        return redirect()->route('asset-tests.index', $asset->id)
            ->with('success','Test opgeslagen');
    }
}
