<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentors = Mentor::all();
        return view('mentor', ['page'=>'mentor', 'mentors'=> $mentors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'number_hp' => ['required'],
            'address' => ['required'],
        ]);
        
        $baru = Mentor::create([
            'name' => $request->name,
            'email' => $request->email,
            'number_hp' => $request->number_hp,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Data division berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Mentor $mentor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mentor $mentor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mentor $mentor)
    {
        $mentor->update($request->only(['name', 'email', 'number_hp', 'address']));

        return redirect()->back()->with('update', 'Data division berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mentor $mentor)
    {
        $mentor->delete();

        return redirect()->back()->with('delete', 'Data mentor '.$mentor->name.' memberhasil dihapus');
    }
}
