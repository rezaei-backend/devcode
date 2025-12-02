<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\team;
use App\Traits\LogsActivity;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TeamController extends Controller
{
    use LogsActivity;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = team::orderBy('created_at', 'desc')->get();
        return view('panel.team.index',compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.team.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required',
            'email' => 'required|unique:teams,email',
            'Expertise'=>'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
$data=$request->all();
        $image='devcode'.time().$request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('images/team'), $image);
        $data['image']=$image;

        $team= Team::create($data);
        $this->LogActivity('create',$team);
        return redirect()->route('team.index')->with('massage','با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $team=team::findorfail($id);
        $data=$request->all();


        if (!empty($data['image'])) {
            $validatedData = $request->validate([
                'fullname' => 'required',
                'email' => 'required',
                'Expertise'=>'required',
                'image' => 'max:2048',
            ]);

            $image='devcode'.time().$request->file('image')->getClientOriginalName();
            $data['image']=$image;
            $public_path=public_path('images/team');

            if (File::exists($public_path.'/'.$team->image)) {
                File::delete($public_path.'/'.$team->image);
            }
            $request->file('image')->move($public_path, $image);



        }else{

            $validatedData = $request->validate([
                'fullname' => 'required',
                'email' => 'required',
                'Expertise'=>'required',
            ]);

        }


        $team->update($data);
        $team->save();

        $this->LogActivity('update',$team);
        return back()->with('massage','با موفقیت ابدیت شد');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $team=team::findorfail($id);
        $team->delete();
        $this->LogActivity('delete',$team);
        return back()->with('unmassage','با موفقیت حذف شد');
    }
}
