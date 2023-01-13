<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Models\User;
use App\Models\Visibility;
use App\Models\Favourites;

class PlaceController extends Controller
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
            'data'    => Place::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar Place
        $validatedData = $request->validate([
            'name' => 'required|String',
            'description' => 'required|String',
            'latitude' => 'required|String',
            'longitude' => 'required|String',
            'visibility_id' => 'required|Integer',
            'author_id' => 'required|Integer',
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
    
        // Obtenir dades del place
        $name = $request->get('name');
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id');
        $author_id = $request->get('author_id');
        $fileSize = $upload->getSize();

        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
    
        if (Storage::disk('public')->exists($filePath)) {

            $fullPath = Storage::disk('public')->path($filePath);
            
            // Desar dades a BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            
            // Desar dades a BD
            $place = Place::create([
                'name' => $name,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'file_id' => $file->id,
                //'category_id' => $category_id,
                'visibility_id' => $visibility_id,
                'author_id' => $author_id
            
        ]);
        return response()->json([
            'success' => true,
            'data'    => $place
        ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading place'
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
        $place = Place::find($id);
        if ($place == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound place'
            ], 404);

        }

        if ($place) {
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error no encontramos el lugar a leer'
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
        $place = Place::find($id);

        if ($place == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound place'
            ], 404);

        }
        // Validar fitxer
        $validatedData = $request->validate([
            'name' => 'required|String',
            'description' => 'required|String',
            'latitude' => 'required|String',
            'longitude' => 'required|String',
            'visibility_id' => 'required|Integer',
            'author_id' => 'required|Integer',
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        
        ]);
   
        // Obtenir dades del place
        $name = $request->get('name');
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id');
        $author_id = $request->get('author_id');
        $fileSize = $upload->getSize();

        // Pujar fitxer al disc dur
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
            'uploads',      // Path
            $uploadName ,   // Filename
            'public'        // Disk
        );
        $file = File::find($place->file_id);

        if ($place) {
            // Desar dades a BD
            $file->filepath = $filePath;
            $file->filesize = $fileSize;
            $file->save();

            $place->name = $name;
            $place->description = $description;
            $place->latitude = $latitude;
            $place->longitude = $longitude;
            $place->visibility_id = $visibility_id;
            $place->author_id = $author_id;
            $place->save();

            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error updating place'
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
        $place = Place::find($id);

        if ($place == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound place'
            ], 404);

        }else{
            $file = File::find($place->file_id);
            $place->delete();
            return response()->json([
                'success' => true,
                'data'    => $place
            ], 200);
        }

        if ($file==null) {
            return response()->json([
                'success'  => false,
                'message' => 'Error place exist'
            ], 404);
        }else {
            $file->delete();
            return response()->json([
                'success' => true,
                'data'    => $file
            ], 200);
        }
    }

    // TODO FAVOURITE Y UNFAVOURITE

    // public function favourites($id){

    //     $place = Place::find($id);

    //     // Desar favourites a la BD
    //     $favourites = Favourites::create([
    //         'place_id' => $place->id,
    //         'user_id'=>auth()->user()->id,
        
    //     ]);

    //     if ($favourites) {
    //         return response()->json([
    //             'success' => true,
    //             'data'    => $favourites
    //         ], 200);
    //     }else {
    //         return response()->json([
    //             'success'  => false,
    //             'message' => 'Error favourite alrready exist'
    //         ], 404);
    //     }
    // }
    // public function unfavourite (Place $place)
    // {

    //     // Eliminar favourites de la BD
    //     $fav = Favourites::where([
    //         ['user_id', '=', auth()->user()->id],
    //         ['place_id', '=', $place->id]
    //     ]);
    //     $fav->first();

    //     $fav->delete();

    //     if ($fav==null) {
    //         return response()->json([
    //             'success' => true,
    //             'data'    => $fav
    //         ], 200);
    //     }else {
    //         return response()->json([
    //             'success'  => false,
    //             'message' => 'Error favourite alrready exist'
    //         ], 404);
    //     }
    // }
}
