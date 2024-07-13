<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();

        return view('event', ['page'=>'event', 'events'=> $events]);
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
            'title' => ['required'],
            'thumbnail' => ['required','image','max:1024','mimes:png, jpg, jpeg'],
            'description' => ['required'],
            'date' => ['required', 'date'],
            'status' => ['required'],
            'author' => ['required', 'exists:users,id'],
        ]);

        $fileNameThumbnail = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
        $path = $request->file('thumbnail')->storeAs('public/upload/thumbnailevent', $fileNameThumbnail);
        
        $baru = Event::create([
            'title' => $request->title,
            'thumbnail' => $path,
            'description' => $request->description,
            'date' => $request->date,
            'status' => $request->status,
            'author' => $request->author,
        ]);

        return redirect()->back()->with('success', 'Data postingan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'thumbnail' => ['image','max:1024','mimes:png, jpg, jpeg'],
            'date' => ['date'],
        ]);

        if($request->file('thumbnail')){
            if($event->thumbnail){
                Storage::delete($event->thumbnail);
            }
            $fileNameThumbnail = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('public/upload/thumbnailevent', $fileNameThumbnail);
            $event->thumbnail = $path;
            $event->save();
        }

        $event->update($request->only(['title','description', 'date','status']));
        
        return redirect()->back()->with('update', 'Data postingan '. $event->title. ' berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if($event->thumbnail){
            Storage::delete($event->thumbnail);
        }
        $event->delete();

        return redirect()->back()->with('delete', 'Data postingan '. $event->title. ' berhasil dihapus');
    }
}
