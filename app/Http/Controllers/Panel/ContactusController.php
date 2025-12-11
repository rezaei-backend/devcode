<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Http\Request;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Contactus::latest()->paginate(15);

        return view('panel.contact-us.index', compact('messages'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $message = Contactus::findOrFail($id);
        return view('panel.contact-us.show', compact('message'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function toggleStatus($id)
    {
        $message = Contactus::findOrFail($id);
        $message->status = $message->status ? 0 : 1; // اگر 1 بود میشه 0، اگر 0 بود میشه 1
        $message->save();

        return redirect()->back()->with('status', 'وضعیت پیام با موفقیت تغییر کرد');
    }
}
