<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    use LogsActivity;

    public function storeOrUpdate(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'url'        => 'required|url|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $resource = Resource::updateOrCreate(
            ['subject_id' => $validated['subject_id']],
            $validated
        );

        $action = $resource->wasRecentlyCreated ? 'created' : 'updated';
        $this->logActivity($action, $resource);

        return redirect()->back()->with('success',
            $resource->wasRecentlyCreated
                ? 'منبع با موفقیت اضافه شد.'
                : 'منبع با موفقیت به‌روزرسانی شد.'
        );
    }
}
