<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function destroy(Request $request)
    {
        // حذف تمام رکوردهای ActivityLog از دیتابیس
        ActivityLog::truncate();

        // بازگشت پاسخ با پیام موفقیت
        return back()->with('success', 'تمامی نوتیفیکیشن‌ها با موفقیت حذف شدند.');
    }
}
