<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\File;
use App\Models\User;
use App\Models\Favorite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("places.index", [
            "places" => Place::all(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("places.create");
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
            'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'category_id' => 'required',
            'visibility_id' => 'required', 
        ]);

        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $name = $request->get('name');
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $category_id = $request->get('category_id');
        $visibility_id = $request->get('visibility_id');
        Log::debug("Storing file '{$fileName}' ($fileSize)...");

        // Desar fitxer al disc i inserir dades a BD
        $file = new File();
        $fileOk = $file->diskSave($upload);

        if ($fileOk) {
            // Desar dades a BD
            Log::debug("Saving place at DB...");
            $place = Place::create([
                'name'           => $name,
                'description'    => $description,
                'file_id'        => $file->id,
                'latitude'       => $latitude,
                'longitude'      => $longitude,
                'category_id'    => $category_id,
                'visibility_id'  => $visibility_id,
                'author_id'      => auth()->user()->id,

            ]);
            Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully saved'));
        } else {
            Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.create")
                ->with('error', __('ERROR Uploading file'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */

    public function show(Place $place)
    {
        
        return view("places.show", [
            'place' => $place,
            'file' => $place->file,
            'user' => $place->user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {   
        if(auth()->user()->id == $place->author_id){
            $file = File::find($place->file_id);

            return view("places.edit", [
                'place'=> $place,
                'file' => $file,
                
            ]);
        }else{
            return abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Place $place)
    {
        if(auth()->user()->id == $place->author_id){
            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,mp4,png|max:1024',
                'name' => 'required',
                'description' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'category_id' => 'required',
                'visibility_id' => 'required'
            ]);

            $file=File::find($place->file_id);

            // Obtenir dades del fitxer
            
            $upload = $request->file('upload');
            $control = false;
            if(! is_null($upload)){
                $fileName = $upload->getClientOriginalName();
                $fileSize = $upload->getSize();

                Log::debug("Storing file '{$fileName}' ($fileSize)...");

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
                Log::debug("Local storage OK");
                $fullPath = \Storage::disk('public')->path($filePath);
                Log::debug("File saved at {$fullPath}");
                }

                // Desar dades a BD
                $file -> filePath = $filePath;
                $file -> fileSize = $fileSize;
                $file->save();
                $place->name = $request->input('name');
                $place->description = $request->input('description');
                $place->latitude = $request->input('latitude');
                $place->longitude = $request->input('longitude');
                $place->category_id = $request->input('category_id');
                $place->visibility_id = $request->input('visibility_id');
                $place->save();
                Log::debug("DB storage OK");

                // Patró PRG amb missatge d'èxit
                return redirect()->route('places.show', $place)
                    ->with('success', 'Place successfully saved');
            } else {
                Log::debug("Local storage FAILS");
                // Patró PRG amb missatge d'error
                return redirect()->route("places.update")
                    ->with('error', 'ERROR uploading file');
            }
        }else{
            return abort(403);
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        if(auth()->user()->id == $place->author_id){
            // Eliminar place de BD
            $place->delete();
            // Eliminar fitxer associat del disc i BD
            $place->file->diskDelete();
            // Patró PRG amb missatge d'èxit
            return redirect()->route("places.index")
                ->with('success', 'Place successfully deleted');
        }else{
            return abort(403);
        }
    }

    public function favorite(Place $place){

        $favorite = Favorite::create([
                'id_user'=> auth()->user()->id,
                'id_place'=> $place->id,
            ]);

        return redirect()->back();
    }

    public function unfavorite(Place $place){
        $id_place = $place->id;
        $id_user = auth()->user()->id;
        $id_favorite = "SELECT id FROM places WHERE id_place = $id_place and id_user = $id_user";
        $id_favorite->delete();
        return redirect()->back();
    }

    public function comprobar_favorite(Place $place){
        $id_post= $place->post_id;
        $id_user = auth()->user()->id;
        $select = "SELECT id FROM places WHERE id_place = $id_place and id_user = $id_user";
        $id_favorite = DB::select($select);
        Log::debug($select);
        return $id_favorite;
    }
}
