<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Registrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrants = Registrant::all();
        $prodis = Prodi::all();

        return view('registrant', ['page'=>'pendaftar', 'registrants'=> $registrants , 'prodis' => $prodis]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'NIM' => ['required'],
            'number_hp' => ['required'],
            'birth_date' => ['required', 'date'],
            'prodi_id' => ['required', 'exists:prodis,id'],
            'motivation_later' => ['required', 'file', 'max:1024', 'mimes:pdf,doc,docx'],
            'CV' => ['required', 'file', 'max:1024', 'mimes:pdf,doc,docx'],
        ]);

        $fileNameMotivation = $request->name . '_motivation_' .time() . '.' . $request->file('motivation_later')->extension();
        $pathMotivation = $request->file('motivation_later')->storeAs('public/upload/registrants', $fileNameMotivation);
        
        $fileNameCV = $request->name . '_CV_' .time() . '.' . $request->file('CV')->extension();
        $pathCV = $request->file('CV')->storeAs('public/upload/registrants', $fileNameCV);
        
        $baru = Registrant::create([
            'name' => $request->name,
            'NIM' => $request->NIM,
            'number_hp' => $request->number_hp,
            'birth_date' => $request->birth_date,
            'prodi_id' => $request->prodi_id,
            'motivation_later' => $pathMotivation,
            'CV' => $pathCV,
            'is_accepted' => 0,
        ]);

        return redirect()->back()->with('success', 'Data division berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Registrant $registrant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registrant $registrant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registrant $registrant)
    {
        $request->validate([
            'birth_date' => ['date'],
            'prodi_id' => ['exists:prodis,id'],
            'motivation_later' => ['file', 'max:1024', 'mimes:pdf,doc,docx'],
            'CV' => ['file', 'max:1024', 'mimes:pdf,doc,docx'],
            'is_accepted' => ['integer'],
        ]);

        if($request->file('motivation_later')){
            if($registrant->motivation_later){
                Storage::delete($registrant->motivation_later);
            }
            $fileNameMotivation = $registrant->name . '_motivation_' .time();
            $pathMotivation = $request->file('motivation_later')->storeAs('public/upload/registrants', $fileNameMotivation);
            $registrant->motivation_later = $pathMotivation;
            $registrant->save();
        }

        if($request->file('CV')){
            if($registrant->CV){
                Storage::delete($registrant->CV);
            }
            $fileNameCV = $registrant->name . '_CV_' .time();
            $pathCV = $request->file('CV')->storeAs('public/upload/registrants', $fileNameCV);
            $registrant->CV = $pathCV;
            $registrant->save();
        }

        $registrant->update($request->only(['name','NIM','number_hp','birth_date','prodi_id','is_accepted']));

        return redirect()->back()->with('update', 'Data pendaftar ' . $registrant->name . ' berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registrant $registrant)
    {
        Storage::delete([$registrant->CV, $registrant->motivation_later]);

        $registrant->delete();

        return redirect()->back()->with('delete', 'Data division ' . $registrant->name . ' berhasil dihapus');
    }
}
