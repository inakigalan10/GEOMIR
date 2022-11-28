<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

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
            "posts" =>Post::all(),
            "files"=>File::all(),
           
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
            'visibility'=>'required',
            
        ]);
         // Obtenir dades del formulari
        $body          = $request->get('body');
        $upload        = $request->file('upload');
        $latitude      = $request->get('latitude');
        $longitude     = $request->get('longitude');
        $visibility     = $request->get('visibility');
          
       // Desar fitxer al disc i inserir dades a BD
       $file = new File();
       $fileOk = $file->diskSave($upload);

       if ($fileOk) {
           // Desar dades a BD
           Log::debug("Saving post at DB...");
           $post = Post::create([
               'body'      => $body,
               'file_id'   => $file->id,
               'latitude'  => $latitude,
               'longitude' => $longitude,
               'visibility_id'=>$visibility,
               'author_id' => auth()->user()->id,
           ]);
           Log::debug("DB storage OK");
           // Patró PRG amb missatge d'èxit
           return redirect()->route('posts.index');
       } else {
           // Patró PRG amb missatge d'error
           return redirect()->route("posts.create");
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
       
        
        if(auth()->user()->id == $post->author_id){
            return view("post.show", [
                'post' => $post,
                'file' => $post->file,
                'user' => $post->user,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(auth()->user()->id == $post->author_id){
            $file=File::find($post->file_id);
            return view("post.edit", [
                'post' => $post,
                'file' => $file,
                
        ]);
        }else {
            return abort('403');
        }
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
        
        if(auth()->user()->id == $post->author_id){
            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,png,mp4|max:1024',
                'body'=>'required',
                'latitude'=>'required',
                'longitude'=>'required',
                
            ]);
            // Obtenir dades del formulari
            $body      = $request->get('body');
            $upload    = $request->file('upload');
            $latitude  = $request->get('latitude');
            $longitude = $request->get('longitude');

            // Desar fitxer (opcional)
            if (is_null($upload) || $post->file->diskSave($upload)) {
                // Actualitzar dades a BD
                Log::debug("Updating DB...");
                $post->body      = $body;
                $post->latitude  = $latitude;
                $post->longitude = $longitude;
                $post->save();
                Log::debug("DB storage OK");
                // Patró PRG amb missatge d'èxit
                return redirect()->route('posts.show', $post);
            } else {
                // Patró PRG amb missatge d'error
                return redirect()->route("posts.edit");
            }
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
        
        if(auth()->user()->id == $post->author_id){
            // Eliminar post de BD
            $post->delete();
            // Eliminar fitxer associat del disc i BD
            $post->file->diskDelete();
            // Patró PRG amb missatge d'èxit
            return redirect()->route("posts.index");
        }else{
            return abort('403');
        }
        
    }
    public function like(Post $post, Like $like){
        // Desar dades a BD
        Log::debug("Saving like at DB...");
        $like = Like::create([
            'id_post'=>$post->post_id,
            'id_user' => auth()->user()->id,
        ]);
        Log::debug("DB storage OK");
        // Patró PRG amb missatge d'èxit
        return redirect()->route('posts.index');
        
    }

    public function unlike(Post $post, Like $like){
        
        $id_like = comprobar_like();
        $id_like->delete();
    }
    
    public function comprobar_like (){
        $id_post= $post->post_id;
        $id_user = auth()->user()->id;
        $id_like = "SELECT id FROM likes WHERE id_post = $id_post and id_user = $id_user";
        return $id_like;
    }
}

