<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Member;
use App\Models\Division;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        $divisions = Division::all();
        $prodis = Prodi::all();
        // $res = Member::find(1)->division;
        // return response()->json($member, 200); 
        return view('member', ['page'=>'anggota', 'members'=> $members , 'divisions' => $divisions, 'prodis'=> $prodis]);
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
            'NIM' => ['required'],
            'name' => ['required'],
            'number_hp' => ['required'],
            'period' => ['required'],
            'birth_date' => ['required', 'date'],
            'division_id' => ['required', 'exists:divisions,id'],
            'prodi_id' => ['required', 'exists:prodis,id'],
        ]);
        
        $baru = Member::create([
            'NIM' => $request->NIM,
            'name' => $request->name,
            'number_hp' => $request->number_hp,
            'period' => $request->period,
            'birth_date' => $request->birth_date,
            'division_id' => $request->division_id,
            'prodi_id' => $request->prodi_id,
        ]);

        return redirect()->back()->with('success', 'Data member berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'birth_date' => ['date'],
            'division_id' => ['exists:divisions,id'],
            'prodi_id' => ['exists:prodis,id'],
        ]);

        $member->update($request->only('NIM','name','number_hp','period','birth_date','division_id','prodi_id'));
        
        return redirect()->back()->with('update', 'Data member berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->back()->with('delete', 'Data division ' . $member->name .' berhasil dihapus');
    }
}
