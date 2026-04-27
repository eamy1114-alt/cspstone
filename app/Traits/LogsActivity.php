<?php

namespace App\Traits;

use App\Models\LogAktivitas;

trait LogsActivity
{
    protected function logActivity($aktivitas, $detail = null)
    {
        if (auth()->check()) {
            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => $aktivitas,
                'ip_address' => request()->ip(),
                'detail' => $detail ? (is_array($detail) ? json_encode($detail) : $detail) : null
            ]);
        }
    }
}