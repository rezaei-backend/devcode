<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    use LogsActivity;

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'url'        => 'required|url|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $resource = Resource::create($validated);

        $this->logActivity('created', $resource);

        return redirect()->back()->with('success', 'منبع با موفقیت اضافه شد.');
    }

    public function update($id, Request $request)
    {
        $resource = Resource::findOrFail($id);

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'url'        => 'required|url|max:255',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $resource->update($validated);

        $this->logActivity('updated', $resource);

        return redirect()->back()->with('success', 'منبع با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $resource = Resource::findOrFail($id);

        $this->logActivity('deleted', $resource);

        $resource->delete();

        return redirect()->back()->with('success', 'منبع با موفقیت حذف شد.');
    }
}
