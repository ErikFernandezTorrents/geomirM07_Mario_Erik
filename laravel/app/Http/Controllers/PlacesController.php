<?php

namespace App\Http\Controllers;

use App\Models\Places;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\User;

class PlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("places.index", [
            "places" => Places::all()
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
            $places = Places::create([
                'name' => $name,
                'description' => $description,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'file_id' => $file->id,
                'author_id'=>$request->user()->id,
            
        ]);
        return redirect()->route('places.show', $places)
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
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function show(Places $place)
    {
        $user=User::find($place->author_id);
        $file = File::find($place->file_id);
        //if (\Storage::disk('public')->exists($places->filepath)) {
            return view("places.show", [
                "places" => $place,
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
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function edit(Places $place)
    {
        $file = File::find($place->file_id);
        return view("places.edit", [
            "places" => $place,
            "file" => $file,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Places $places)
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

        $file=File::find($places->file_id);

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
            $places->name = $request->input('name');
            $places->description = $request->input('description');
            $places->latitude = $request->input('latitude');
            $places->longitude = $request->input('longitude');
            $places->save();
            \Log::debug("DB storage OK");

            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $places)
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
     * @param  \App\Models\Places  $places
     * @return \Illuminate\Http\Response
     */
    public function destroy(Places $place)
    {
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
        \Log::debug("place Delete");
        // Patró PRG amb missatge d'error
        return redirect()->route("places.index")
        ->with('succes', 'place Deleted');
        }
        // $file = File::find($place->file_id);

        // if (\Storage::disk('public')->exists($file->filepath)) {
        //     File::destroy($file->id);
        //     Places::destroy($place->id);
        //     return redirect()->route('places.show', $place)
        //         ->with('error', 'ERROR el Lloc encara existeix al disc');
        // } else {       
        //     return redirect()->route("places.index")
        //         ->with('success', 'LLoc eliminat correctament!');
        // }
    }
}
