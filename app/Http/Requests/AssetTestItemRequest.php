<?php

namespace App\Http\Requests;

class AssetTestItemRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asset_test_run_id' => 'sometimes|exists:asset_test_runs,id',
            'component' => 'required|string',
            'status' => 'required|in:pass,fail,na',
            'notes' => 'nullable|string',
            'completed_at' => 'nullable|date',
        ];
    }
}
