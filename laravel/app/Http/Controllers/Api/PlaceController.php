<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\File;
use App\Models\User;
use App\Models\Favorite;


class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = place::all();
        return response()->json([
            'success' => true,
            'data' => $places,
        ], 200);
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
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
        ]);

        
        // Obtenir dades del fitxer
        $name = $request->get('name');
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $description = $request->get('description'); 
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude'); 
        $visibility_id = $request->get('visibility_id');
        $category_id=$request->get('category_id');
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
            $place = place::create([
                'name' => $name,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'file_id' => $file->id,
                'author_id' => auth()->user()->id,
                'visibility_id' => $visibility_id,
                'category_id'=>$category_id
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 201);
        } else {
            \Log::debug("Local storage FAILS");
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = place::find($id);
        if($place == null)
        {
            return response()->json([
                'success'  => false,
                'message' => 'Error place not found'
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $place = place::find($id);

        if($place)
        {
            $file = File::find($place->file_id);
            // Validar fitxer
            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048'
            ]);

            // Obtenir dades del fitxer
            $upload = $request->file('upload');
            $fileName = $upload->getClientOriginalName();
            $fileSize = $upload->getSize();
            $description = $request->get('description'); 
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude'); 
            $visibility_id = $request->get('visibility_id');
            $category_id=$request->get('category_id');
            \Log::debug("Storing file '{$fileName}' ($fileSize)...");
    
            // Pujar fitxer al disc dur
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',      // Path
                $uploadName ,   // Filename
                'public'        // Disk
            );
            if(\Storage::disk('public')->exists($filePath)){
                \Log::debug("Local storage OK");
                $fullPath = \Storage::disk('public')->path($filePath);
                \Log::debug("File saved at {$fullPath}");
                // Desar dades a BD
                $file->filepath = $filePath;
                $file->filesize = $fileSize;
                $file->save();

                $place->description = $description;
                $place->latitude = $latitude;
                $place->longitude = $longitude;
                $place->visibility_id = $visibility_id;
                $place->category_id=$category_id;
                $place->save();
                \Log::debug("DB storage OK");
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 201);
            } else {
                \Log::debug("Local storage FAILS");
                return response()->json([
                    'success'  => false,
                    'message' => 'Error uploading place'
                ], 500);
            }
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error place not found'
            ], 404);
        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = place::find($id);
        
        if($place == null)
        {
            return response()->json([
                'success'  => false,
                'message' => 'Error place not found'
            ], 404);
        }else{
            $file = File::find($place->file_id);
            $place->delete();
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }

        if ($file == null) {
            \Log::debug(" Alredy Exist");
            return response()->json([
                'success'  => false,
                'message' => 'Error place exist'
            ], 404);
        }else{
            \Storage::disk('public')->delete($file->filepath);
            $file->delete();
            \Log::debug("place Delete");
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }  
    }

    public function favorite($id)
    {
        $place=place::find($id);
        if (Favorite::where([
                ['id_user', "=" , auth()->user()->id],
                ['id_place', "=" ,$id],
            ])->exists()) {
            return response()->json([
                'success'  => false,
                'message' => 'The place is already favorite'
            ], 500);
        }else{
            $favorite = favorite::create([
                'id_user' => auth()->user()->id,
                'id_place' => $place->id,
            ]);
            return response()->json([
                'success' => true,
                'data'    => $favorite
            ], 200);
        }        
    }

    public function unfavorite($id)
    {
        $place=place::find($id);
        if (favorite::where([['id_user', "=" ,auth()->user()->id],['id_place', "=" ,$place->id],])->exists()) {
            
            $favorite = favorite::where([
                ['id_user', "=" ,auth()->user()->id],
                ['id_place', "=" ,$id],
            ]);
            $favorite->first();
    
            $favorite->delete();

            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'The place is not favorite'
            ], 500);
            
        }  
        
    }

}