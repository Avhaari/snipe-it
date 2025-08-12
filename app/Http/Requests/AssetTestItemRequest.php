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
            'component' => 'required|in:keyboard,screen,touchpad,usb,sd,dvd,vga,hdmi,cpu_stress,battery,ram,webcam,mic,speakers,wifi,bluetooth,ethernet,fingerprint',
            'status' => 'required|in:pass,fail,na',
            'notes' => 'nullable|string',
        ];
    }
}
