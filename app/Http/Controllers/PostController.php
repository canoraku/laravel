<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return view('post', ['page'=>'berita', 'posts'=> $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $posts = Post::with('author')->get();
        // $posts = Post::all();
        return $posts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'thumbnail' => ['required','image','max:1024','mimes:png, jpg, jpeg'],
            'content' => ['required'],
            'author' => ['required', 'exists:users,id'],
            'expired' => ['required', 'date'],
        ]);

        $fileNameThumbnail = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
        $path = $request->file('thumbnail')->storeAs('public/upload/thumbnailpost', $fileNameThumbnail);
        
        $baru = Post::create([
            'title' => $request->title,
            'thumbnail' => $path,
            'content' => $request->content,
            'author' => $request->author,
            'expired' => $request->expired,
        ]);

        return redirect()->back()->with('success', 'Data postingan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'thumbnail' => ['image','max:1024','mimes:png, jpg, jpeg'],
            'expired' => ['date'],
        ]);

        if($request->file('thumbnail')){
            if($post->thumbnail){
                Storage::delete($post->thumbnail);
            }
            $fileNameThumbnail = time() . '_' . $request->file('thumbnail')->getClientOriginalName();
            $path = $request->file('thumbnail')->storeAs('public/upload/thumbnailpost', $fileNameThumbnail);
            $post->thumbnail = $path;
            $post->save();
        }

        $post->update($request->only(['title','content','expired']));
        
        return redirect()->back()->with('update', 'Data postingan '. $post->title. ' berhasil dirubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->thumbnail){
            Storage::delete($post->thumbnail);
        }
        $post->delete();

        return redirect()->back()->with('delete', 'Data postingan '. $post->title. ' berhasil dihapus');
    }
}
