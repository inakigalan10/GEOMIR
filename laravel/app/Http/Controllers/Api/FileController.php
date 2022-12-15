<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\File;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $files = File::all();
         return response()->json([
            'success'=>true,
            'data'=>$files,
         ],200);
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
       // Desar fitxer al disc i inserir dades a BD
       $upload = $request->file('upload');
       $file = new File();
       $ok = $file->diskSave($upload);
 
       if ($ok) {
           return response()->json([
               'success' => true,
               'data'    => $file
           ], 201);
       } else {
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
        $file = File::find($id);
        if(!empty($file)){
            return response()->json([
                'success'=>true,
                'data'=>$file,
             ],200);
        }
        else {
            return response()->json([
                'success'=>false,
                'message'=>"El archivo no existe"
             ],404);
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
        $file=File::find($id);
        if($file){
            $validatedData = $request->validate([
                'upload' => 'required|mimes:gif,jpeg,jpg,png|max: 2048'
            ]);
        
            $upload = $request->file('upload');
            $fileName=$upload->getClientOriginalName();
            $fileSize =$upload->getSize(); 
            \Log::debug("Storing file '{$fileName}' ($fileSize)...");
            
            $uploadName = time(). '_'. $fileName;
            $filePath =$upload->storeAs( 
                'uploads', 
                $uploadName, 
                'public' 
            );
            if(\Storage::disk('public')->exists($filePath)){
                \Log::debug("Local storage OK");
                $fullPath =\Storage::disk('public')->path($filePath);
                
                \Log::debug("File saved at {$fullPath}");
                
                $file->filepath = $filePath; 
                $file->filesize = $fileSize;
                $file->save();
                
                \Log::debug("DB storage OK");
                
                return response()->json([
                    'success' => true, 
                    'data' => $file
                    ], 200);
                
                } else {
                
                \Log::debug("Local storage FAILS"); 
                    return response()->json([
                        'success' => false,
                        'message'=>'Error uploading file'
                    ],421);
                }
                
        } else {
            return response()->json([ 
            'success' => false,
            'message' => 'Error file not found'
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
      
       // Patró PRG amb missatge d'èxit
       $file = File::find($id);
       if(!empty($file)){
        $file->diskDelete();
        return response()->json([
            'success'=>true,
            'data'=>$file,
         ],200);
    }
    else {
        return response()->json([
            'success'=>false,
            'message'=>"El archivo no existe"
         ],404);
    }
    }
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }
 
 
}
