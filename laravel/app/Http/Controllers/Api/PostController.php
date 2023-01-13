<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Likes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store', 'Like', 'update');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data'    => Post::all()
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
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024',
            'body' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'visibility_id' => 'required',            
            'author_id' => 'required',
        ]);
   
        // Obtenir dades del fitxer
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $body = $request->get('body');
        $latitude = $request->get('latitude');
        $longitude = $request->get('longitude');
        $visibility_id = $request->get('visibility_id');
        $author_id = $request->get('author_id');

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
            $post = Post::create([
                'body' => $body,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'visibility_id' => $visibility_id,
                'file_id' => $file->id,   
                'author_id'=>$author_id,
        ]); 

        return response()->json([
            'success' => true,
            'data'    => $post
        ], 201);
        } else {
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading post'
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
        $post = Post::find($id);
        if ($post == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound post'
            ], 404);

        }

        if ($post) {
            return response()->json([
                'success' => true,
                'data'    => $post
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
        $post = Post::find($id);

        if ($post == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound post'
            ], 404);

        }
        // Validar fitxer
        $validatedData = $request->validate([
            'body' => 'required|String',
            'latitude' => 'required|String',
            'longitude' => 'required|String',
            'visibility_id' => 'required|Integer',
            'author_id' => 'required|Integer',
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
        
        ]);
   
        // Obtenir dades del post
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $body = $request->get('body');
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
        $file = File::find($post->file_id);

        if ($post) {
            // Desar dades a BD
            $file->filepath = $filePath;
            $file->filesize = $fileSize;
            $file->save();

            $post->body = $body;
            $post->latitude = $latitude;
            $post->longitude = $longitude;
            $post->visibility_id = $visibility_id;
            $post->author_id = $author_id;
            $post->save();

            return response()->json([
                'success' => true,
                'data'    => $post
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error updating post'
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
        $post = Post::find($id);

        if ($post == null){
            return response()->json([
                'success'  => false,
                'message' => 'Error notFound post'
            ], 404);

        }else{
            $file = File::find($post->file_id);
            if ($file==null) {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error file notFound'
                ], 404);
            } else {
                $post->delete();
                $file->delete();
                return response()->json([
                    'success' => true,
                    'data'    => $post
                ], 200);
            }
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function likes($id) {
       
        $post = Post::find($id);

        // Desar likes a la BD
        $likes = Likes::create([
            'post_id' => $post->id,
            'user_id'=>auth()->user()->id,
        
        ]);

        if ($likes) {
            return response()->json([
                'success' => true,
                'data'    => $likes
            ], 200);
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error favourite alrready exist'
            ], 500);
        }
    }
    
    public function unlike (Post $post)
    {
        try
        {
            $like = Likes::where([
                ['user_id', '=', auth()->user()->id],
                ['post_id', '=', $post->id]
            ]);
            $like->first();

            $like->delete();

        } catch (\Illuminate\Database\QueryException $e) {

            Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error like alrready exist'
            ], 500);
        }
        return response()->json([
            'success' => true,
            'data' => 'place unliked'
        ], 200);
    }
}
