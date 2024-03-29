<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\File;
use App\Models\User;
use App\Models\Visibility;
use Illuminate\Http\Request;
use App\Models\Likes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
    $this->middleware('permission:posts.list')->only('index');
    $this->middleware('permission:posts.create')->only(['create','store']);
    $this->middleware('permission:posts.read')->only('show');
    $this->middleware('permission:posts.update')->only(['edit','update']);
    $this->middleware('permission:posts.delete')->only('destroy');
    }

    public function index()
    {   
        return view("posts.index", [
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
        return view("posts.create", [
            "visibilities"=> Visibility::all(),
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
      // Validar fitxer
      $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);

        // Validar post
        $validatedData = $request->validate([
            'body' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'visibility_id' => 'required',
        ]);
   
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        Log::debug("Storing file '{$fileName}' ($fileSize)...");
        // obtenir dades de post
        $body = $request->get('body');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id');

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
        

        // Desar dades a BD
        $post = Post::create([
            'body' => $body,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'visibility_id' => $visibility_id,
            'file_id' => $file->id,   
            'author_id'=>auth()->user()->id,
        ]);
        Log::debug("DB storage OK");
             return redirect()->route('posts.show', $post)
                 ->with('success', 'Post successfully saved');
         } else {
            Log::debug("Local storage FAILS");
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
        $user=User::find($post->author_id);
        $file = File::find($post->file_id);

        $post->loadCount('likes');

        $is_like = false;
        try {
            if (Likes::where('user_id', '=', $user->id)->where('post_id','=', $post->id)->exists()) {
                $is_like = true;
            }
        } catch (Exception $e) {
            $is_like = false;
        }

        return view("posts.show", [
            "post" => $post,
            "file" => $file,
            "user" => $user,
            'is_like' => $is_like,
            'post' => $post,
            'file' => $file,
            'user' => $user,
            'numLikes' => $post->likes_count,
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
        if ( auth()->user()->id == $post->author_id){ 
            return view("posts.edit", [
                'post' => $post,
                'file' => $post->file,   
            ]);
        }
        else{
            return redirect()->back()
                ->with('error',__('You are not the author of the post'));
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
         // Validar fitxer
       $validatedData = $request->validate([
        'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        ]);

        // Validar post
        $validatedData = $request->validate([
            'body' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $file=File::find($post->file_id);
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
            Storage::disk('public')->delete($file->filepath);
            Log::debug("Local storage OK");
            $fullPath = Storage::disk('public')->path($filePath);
            Log::debug("File saved at {$fullPath}");
            }
            // Desar dades a BD
            $file -> filePath = $filePath;
            $file -> fileSize = $fileSize;
            $file->save();
            $post->body = $request->input('body');
            $post->latitude = $request->input('latitude');
            $post->longitude = $request->input('longitude');
            $post->save();
            Log::debug("DB storage OK");

            // Patró PRG amb missatge d'èxit
            return redirect()->route('posts.index', $post)
                ->with('success', 'Post successfully updated');
        } else {
            Log::debug("Local storage FAILS");
            // Patró PRG amb missatge d'error
            return redirect()->route("posts.update")
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
        if ( auth()->user()->id == $post->author_id) {
            if ( auth()->user()->id == $post->author_id){ 
                $file=File::find($post->file_id);
                
                Storage::disk('public')->delete($post->id);
                $post->delete();


                Storage::disk('public')->delete($file->filepath);
                $file->delete();

                if (Storage::disk('public')->exists($post->id)) {
                    Log::debug("Local storage OK");
                    
                    return redirect()->route('posts.show', $post)
                        ->with('error', 'Error post alredy exist');
                } else {
                    Log::debug("Post Delete");
                    // Patró PRG amb missatge d'error
                    return redirect()->route("posts.index")
                        ->with('succes', 'Post Deleted');
                }
            }
            else{
                return redirect()->back()
                    ->with('error',__('You are not the author of the post'));
            }
        if ( auth()->user()->id == $post->author_id){ 
            $file=File::find($post->file_id);
            
            Storage::disk('public')->delete($post->id);
            $post->delete();


            Storage::disk('public')->delete($file->filepath);
            $file->delete();

            if (Storage::disk('public')->exists($post->id)) {
                Log::debug("Local storage OK");
                
                return redirect()->route('posts.show', $post)
                    ->with('error', 'Error post alredy exist');
            } else {
                Log::debug("Post Delete");
                // Patró PRG amb missatge d'error
                return redirect()->route("posts.index")
                    ->with('succes', 'Post Deleted');
            }
        }
        else{
            return redirect()->back()
                ->with('error',__('You are not the author of the post'));
        }
    }
    }

    public function likes(Post $post) {
       

        // Desar likes a la BD
        $likes = Likes::create([
            'post_id' => $post->id,
            'user_id'=>auth()->user()->id,
        
        ]);

        return redirect()->back();

    }
    public function unlike (Post $post)
    {
        // Eliminar favourites de la BD
        
        $like = Likes::where([
            ['user_id', '=', auth()->user()->id],
            ['post_id', '=', $post->id]
        ]);
        $like->first();

        $like->delete();

        return redirect()->back();
    }
}