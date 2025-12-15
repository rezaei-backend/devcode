<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

//    public function getJalaliTimeAttribute()
//    {
//        return datejallali($this->created_at, true);
//    }
//
//    public function getJalaliDateAttribute()
//    {
//        return datejallali($this->created_at, 1);
//    }
//
//    public function getJalaliDatePersianAttribute()
//    {
//        return datejallali($this->created_at, 2);
//    }

    public static function record($action, $modelClass, $modelId, $extraInfo = '')
    {
        $modelType = class_basename($modelClass);

        self::create([
            'action'      => $action,
            'model_type'  => $modelType,
            'model_id'    => $modelId,
            'description' => $extraInfo,
            'user_id'     => Auth::id(),
        ]);

        $user = Auth::user();
        $userName = $user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'ناشناس' : 'ناشناس';

        $logEntry = sprintf(
            "[%s] کاربر: %s | %s\n",
            now()->timezone('Asia/Tehran')->format('Y/m/d H:i:s'),
            $userName,
            $extraInfo
        );

        try {
            $logFile = public_path('logs.txt');
            if (!file_exists($logFile)) {
                file_put_contents($logFile, "=== لاگ فعالیت‌های پنل ===\n\n");
            }
            file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
        } catch (\Exception $e) {
            \Log::error('خطا در نوشتن لاگ فایل: ' . $e->getMessage());
        }
    }
}
