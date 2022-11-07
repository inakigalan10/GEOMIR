<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("post.index", [
            "posts" => Post::all()
        ]);
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("post.create");

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar fitxer
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png,mp4|max:1024',
            'body'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            
        ]);
          // Obtenir dades del fitxer
          $upload = $request->file('upload');
          $fileName = $upload->getClientOriginalName();
          $fileSize = $upload->getSize();
          $body = $request->get('body');
          $latitude=$request->get('latitude');
          $longitude=$request->get('longitude');
          \Log::debug("Storing file '{$fileName}' ($fileSize)...");
          
        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
       
        if (\Storage::disk('public')->exists($filePath)) {
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            // Desar dades a BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            $post = Post::create([
                'body' =>$body,
                'file_id'=>$file->id,
                'latitude'=>$latitude,
                'longitude'=>$longitude,
                'author_id'=>auth()->user()->id,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('post.show', $post)
                ->with('success', 'Post successfully saved');
        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("posts.create")
                ->with('error', 'ERROR uploading posts');
        }
        
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
       
        $user=User::find("$post->author_id");
        return view("post.show", [
            'post' => $post,
            'file' => $post->file(),
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $file=File::find("$post->file_id");
        return view("post.edit", [
            'post' => $post,
            'file' => $file,   
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png,mp4|max:1024',
            'body'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            
        ]);
        $file=File::find($post->file_id);
         // Obtenir dades del fitxer
         $upload = $request->file('upload');
         $control = false;
        if(! is_null($upload)){
            $fileName = $upload->getClientOriginalName();
            $fileSize = $upload->getSize();
            \Log::debug("Storing file '{$fileName}' ($fileSize)...");
            // Pujar fitxer al disc dur
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',      // Path
                $uploadName ,   // Filename
                'public'        // Disk
            );
        }else{
            $filePath = $file->filepath;
            $fileSize = $file->filesize;
            $control = true;
        }
        if (\Storage::disk('public')->exists($filePath)) {
            if(!$control){
            \Storage::disk('public')->delete($file->filepath);
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            }
            // Desar dades a BD
            $file -> filePath = $filePath;
            $file -> fileSize = $fileSize;
            $file->save();
            $post->body = $request->input('body');
            $post->latitude = $request->input('latitude');
            $post->longitude = $request->input('longitude');
            $post->save();
            \Log::debug("DB storage OK");

            // Patró PRG amb missatge d'èxit
            return redirect()->route('post.index', $post)
                ->with('success', 'Post successfully updated');
        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("post.update")
                ->with('error', 'ERROR updating Post');
        }
        }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $file=File::find("$post->file_id");
        
        \Storage::disk('public')->delete($post->id);
        $post->delete();


        \Storage::disk('public')->delete($file->filepath);
        $file->delete();

         if (\Storage::disk('public')->exists($post->id)) {
            \Log::debug("Local storage OK");
            
            return redirect()->route('post.show', $post)
                ->with('error', 'Error post alredy exist');
        } else {
            \Log::debug("Post Delete");
            // Patró PRG amb missatge d'error
            return redirect()->route("post.index")
                ->with('succes', 'Post Deleted');
        }
    }
}
