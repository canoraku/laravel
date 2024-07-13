<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Division;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::all();
        // return $divisions;
        return view('division', ['page'=>'divisi', 'divisions'=> $divisions]);
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description' => ['required']
        ]);
        
        $baru = Division::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Data division berhasil ditambahkan');
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {   
        $division->update($request->only(['name', 'description']));
        return redirect()->back()->with('update', 'Data division berhasil dirubah');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        $division->delete();

        return redirect()->back()->with('delete', 'Data ' . $division->name . ' berhasil dihapus');
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
         */
        public function show(Division $division)
        {
            return $division;
        }
    
        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Division $division)
        {
            return $division;
        }
}
