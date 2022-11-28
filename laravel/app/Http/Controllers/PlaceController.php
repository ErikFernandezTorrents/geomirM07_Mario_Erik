<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
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
    public function index()//Place $place
    {
        return view("places.index", [
            "place" => Place::all(),
            //"visibilities" => Visibility::all(),
            
        ]);
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("places.create", [
            "visibilities" => Visibility::all(),
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
        $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
        // Validar Place
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'visibility_id' => 'required',
        ]);
    
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $description = $request->get('description');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        //$category_id = $request->get('category_id');
        $visibility_id = $request->get('visibility_id');
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
            // Obtenir dades de place
            $name = $request->get('name');
            \Log::debug($name);
            $description = $request->get('description');
            $latitude = $request->get('latitude');
            $longitude = $request->get('longitude');

            
            // Desar dades a BD
            $place = Place::create([
                'name' => $name,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'file_id' => $file->id,
                //'category_id' => $category_id,
                'visibility_id' => $visibility_id,
                'author_id'=>auth()->user()->id,
            
        ]);
        return redirect()->route('places.show', $place)
        ->with('success', 'Place successfully saved');
        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.update")
                ->with('error', 'ERROR uploading file');
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
        $user=User::find($place->author_id);
        $file = File::find($place->file_id);

        $is_favourite = false;
        try {
            if (Favourites::where('user_id', '=', auth()->user()->id)->where('place_id','=', $place->id)->exists()) {
                $is_favourite = true;
            }
        } catch (Exception $e) {
            $is_favourite = false;
        }
        return view("places.show", [
            "place" => $place,
            "file" => $file,
            "user" => $user,
            'is_favourite' => $is_favourite,
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
        \Log::debug(auth()->user()->role_id);
    
        if ( auth()->user()->id == $place->author_id ){ 
            return view("places.edit", [
                "place" => $place,
                "file" => $place->file,
                "visibilities" => Visibility::all(),
            ]);
        }
        else{
            return redirect()->back()
                ->with('error',__('You are not the author of the place'));
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
        $validatedData = $request->validate([
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
            ]);
            // Validar Place
            $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'visibility_id' => 'required',

            ]);

        $file=File::find($place->file_id);
        \Log::debug("ID file:" . $place->files_id);

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
            \Storage::disk('public')->delete($filePath);
            \Log::debug("Local storage OK");
            $fullPath = \Storage::disk('public')->path($filePath);
            \Log::debug("File saved at {$fullPath}");
            }

            // Desar dades a BD
            $file -> filePath = $filePath;
            $file -> fileSize = $fileSize;
            $file->save();
            $place->name = $request->input('name');
            $place->description = $request->input('description');
            $place->latitude = $request->input('latitude');
            $place->longitude = $request->input('longitude');
            $place->visibility_id = $request->input('visibility_id');
            $place->save();
            \Log::debug("DB storage OK");

            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', 'Place successfully saved');
        } else {
            \Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.update")
                ->with('error', 'ERROR uploading file');
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
        if ( auth()->user()->id == $place->author_id){ 
            $file=File::find($place->file_id);

            \Storage::disk('public')->delete($place->id);
            $place->delete();


            \Storage::disk('public')->delete($file->filepath);
            $file->delete();

            if (\Storage::disk('public')->exists($place->id)) {
            \Log::debug("Local storage OK");

            return redirect()->route('places.show', $place)
            ->with('error', 'Error place alredy exist');
            } else {
            \Log::debug("places Delete");
            // Patró PRG amb missatge d'error
            return redirect()->route("places.index")
            ->with('succes', 'places Deleted');
            }
        
        }
        else{
            return redirect()->back()
                ->with('error',__('You are not the author of the place'));
        }
    }
    public function favourites(Place $place){
        $user=User::find($place->author_id);

        // Desar favourites a la BD
        $favourites = Favourites::create([
            'place_id' => $place->id,
            'user_id'=>$user->id,
        
        ]);

        return redirect()->back();

    }
    public function unfavourite (Place $place)
    {

        // Eliminar favourites de la BD
        $user=User::find($place->author_id);
        $fav = Favourites::where([
            ['user_id', '=', $user->id],
            ['place_id', '=', $place->id]
        ]);
        $fav->first();

        $fav->delete();

        return redirect()->back();
    }

}
