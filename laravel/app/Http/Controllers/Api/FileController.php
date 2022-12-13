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
        return response()->json([
            'success' => true,
            'data'    => File::all()
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
       // Desar fitxer al disc i inserir dades a BD
       $upload = $request->file('upload');
       $fileName = $upload->getClientOriginalName();
       $fileSize = $upload->getSize();

       // Pujar fitxer al disc dur
       $uploadName = time() . '_' . $fileName;
       $filePath = $upload->storeAs(
           'uploads',      // Path
           $uploadName ,   // Filename
           'public'        // Disk
       );
 
       if (\Storage::disk('public')->exists($filePath)) {
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
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
        if ($file == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound file'
            ], 404);

        }

        if ($file) {
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error no encontramos el fichero a leer'
            ], 500);
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
        $file = File::find($id);

        if ($file == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound file'
            ], 404);

        }
        // Validar fitxer
        $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
   
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();

        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );


        if (\Storage::disk('public')->exists($filePath)) {
            // Desar dades a BD
            $file->filepath = $filePath;
            $file->filesize = $fileSize;
            $file->save();

            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error updating file'
            ], 500);
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
        $file = File::find($id);

        if ($file == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound file'
            ], 404);

        }
        $file->delete();

        if (\Storage::disk('public')->exists($file->filepath)) {
            \Storage::disk('public')->delete($file->filepath);
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error destoyng file'
            ], 500);
        }



    }
}
