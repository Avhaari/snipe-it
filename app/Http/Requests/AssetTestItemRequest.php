<?php

namespace App\Http\Requests;

use App\Models\AssetTestItem;
use Illuminate\Validation\Rule;

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
            'component' => 'required|in:' . implode(',', AssetTestItem::COMPONENTS),
            'status' => 'required|in:pass,fail,na',
            'notes' => 'nullable|string',
            'completed_at' => 'nullable|date',
        ];
    }
}
