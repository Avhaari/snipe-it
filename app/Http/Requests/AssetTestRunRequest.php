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
            'os_version' => 'nullable|string',
            'notes' => 'nullable|string',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date|after_or_equal:started_at',
        ];
    }
}
