<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
            "place" => Place::all()
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
        $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
        // Validar Place
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
    
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
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
    
        if (Storage::disk('public')->exists($filePath)) {
            Log::debug("Local storage OK");
            $fullPath = Storage::disk('public')->path($filePath);
            Log::debug("File saved at {$fullPath}");
            // Desar dades a BD
            $file = File::create([
                'filepath' => $filePath,
                'filesize' => $fileSize,
            ]);
            // Obtenir dades de place
            $name = $request->get('name');
            Log::debug($name);
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
                'author_id'=>$request->user()->id,
            
        ]);
        return redirect()->route('places.show', $place)
        ->with('success', 'Place successfully saved');
        } else {
            Log::debug("Local storage FAILS");
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
        //if (Storage::disk('public')->exists($place->filepath)) {
            return view("places.show", [
                "place" => $place,
                "file" => $file,
                "user" => $user,
            ]);
        //}
        //else{
            //return redirect()->route("files.index")
            //    ->with('error', 'ERROR the file does not exist on the hard drive');
        //}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function edit(Place $place)
    {
        $file = File::find($place->file_id);
        return view("places.edit", [
            "place" => $place,
            "file" => $file,
        ]);
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
                'longitude' => 'required'
            ]);

        $file=File::find($place->file_id);
        Log::debug("ID file:" . $place->files_id);

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

        if (Storage::disk('public')->exists($filePath)) {
            if(!$control){
            Storage::disk('public')->delete($filePath);
            Log::debug("Local storage OK");
            $fullPath = Storage::disk('public')->path($filePath);
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Place  $place
     * @return \Illuminate\Http\Response
     */
    public function destroy(Place $place)
    {
        $file=File::find($place->file_id);

        Storage::disk('public')->delete($place->id);
        $place->delete();


        Storage::disk('public')->delete($file->filepath);
        $file->delete();

        if (Storage::disk('public')->exists($place->id)) {
        Log::debug("Local storage OK");

        return redirect()->route('places.show', $place)
        ->with('error', 'Error place alredy exist');
        } else {
        Log::debug("places Delete");
        // Patró PRG amb missatge d'error
        return redirect()->route("places.index")
        ->with('succes', 'places Deleted');
        }
        // $file = File::find($place->file_id);

        // if (Storage::disk('public')->exists($file->filepath)) {
        //     File::destroy($file->id);
        //     place::destroy($place->id);
        //     return redirect()->route('place.show', $place)
        //         ->with('error', 'ERROR el Lloc encara existeix al disc');
        // } else {       
        //     return redirect()->route("place.index")
        //         ->with('success', 'LLoc eliminat correctament!');
        // }
    }
}
