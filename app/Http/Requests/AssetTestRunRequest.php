<?php

namespace App\Http\Requests;

class AssetTestRunRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'test_type' => 'nullable|string',
            'status' => 'nullable|in:in_progress,completed',
            'os_version' => 'nullable|string',
            'notes' => 'nullable|string',
            'finished_at' => 'nullable|date',
        ];
    }
}
