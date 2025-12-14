<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log; // اضافه برای لاگ
use Illuminate\Validation\Rule;

class TeamController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $teams = Team::paginate(10); // Added pagination to match blade expectations
        return view('panel.team.index', compact('teams'));
    }

    public function create()
    {
        return view('panel.team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'Expertise' => 'required|string|max:255',
            'email' => ['required', 'string', 'max:255', Rule::unique('teams')],
            'phone' => 'nullable|string|max:255',
            'resume' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $destinationPath = public_path('images/team/');

        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $fileName);
            $data['image'] = $fileName;
        }

        $team = Team::create($data);

        $this->logActivity('created', $team);

        return redirect()->route('team.index')->with('success', 'عضو تیم با موفقیت اضافه شد.');
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('panel.team.edit', compact('team'));
    }

    public function update(Request $request, string $id)
    {
        $team = Team::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:255',
            'Expertise' => 'required|string|max:255',
            'email' => ['required', 'string', 'max:255', Rule::unique('teams')->ignore($team->id)],
            'phone' => 'nullable|string|max:255',
            'resume' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'fullname', 'Expertise', 'email', 'phone', 'resume'
        ]);

        $destinationPath = public_path('images/team/');

        // دیباگ سریع: dd($request->input('remove_image')); // uncomment برای تست (بعد حذف کنین)

        if ($request->input('remove_image') === '1') {
            Log::info('Remove image triggered for team ID: ' . $id); // لاگ اختیاری

            if ($team->image && File::exists($destinationPath . $team->image)) {
                Log::info('File exists, deleting: ' . $destinationPath . $team->image);
                $deleted = File::delete($destinationPath . $team->image);
                Log::info('Delete result: ' . ($deleted ? 'success' : 'failed'));
                if (!$deleted) {
                    // اختیاری: خطا بندازین یا redirect با error
                    return redirect()->back()->with('error', 'خطا در حذف فایل عکس. مجوزها را چک کنید.');
                }
            } else {
                Log::warning('File not found or no image: ' . ($team->image ?? 'null') . ' for team ID: ' . $id);
            }
            $data['image'] = null;
        }

        if ($request->hasFile('image')) {
            if ($team->image && File::exists($destinationPath . $team->image)) {
                File::delete($destinationPath . $team->image);
            }
            $fileName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $fileName);
            $data['image'] = $fileName;
        }

        $team->update($data);

        // دیباگ: $team->refresh(); dd($team->image); // uncomment برای چک (باید null باشه)

        $this->logActivity('updated', $team);

        return redirect()->route('team.index')->with('success', 'عضو تیم با موفقیت ویرایش شد.');
    }

    public function destroy(string $id)
    {
        $team = Team::findOrFail($id);

        $destinationPath = public_path('images/team/');
        if ($team->image && File::exists($destinationPath . $team->image)) {
            File::delete($destinationPath . $team->image);
        }

        $this->logActivity('deleted', $team);

        $team->delete();

        return redirect()->route('team.index')->with('success', 'عضو تیم با موفقیت حذف شد.');
    }
}
