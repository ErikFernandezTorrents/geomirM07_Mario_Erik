@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="cardForms">
               <div class="card-header"><p class="blanco">{{ $user->name }}</p></div>
               <div class="card-body">
                   <table class="table">
                       <tbody>
                           
                           <tr>
                                <td scope="col">{{__('fields.body')}}</td>
                                <td>{{ $post->body }}</td> 
                           </tr>
                          
                           <tr>
                                <td scope="col" >Latitude</td>
                                <td>{{ $post->latitude }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">Longitude</td>
                                <td>{{ $post->longitude }}</td> 
                           </tr>
                           <tr>
                               <td scope="col">Created</td>
                               <td>{{ $post->created_at }}</td>
                           </tr>
                           <tr>
                                <td scope="col">img</td>
                                <td aling="center"> <img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td> 
                           </tr>
<<<<<<< HEAD
                           <tr >
                                <td><a class="btn btn-primary noborder" href="{{ route('posts.edit',$post) }}" role="button">Editar</a></td>
                                <td><a class="btn btn-primary noborder" href="{{ url('/posts') }}" role="button">Index</a></td>
                                <td class="noborder">
                                    <form method="post" action="{{ route('posts.destroy',$post) }}" >
                                        @csrf     
                                        @method('DELETE')
                                            
                                        <button class="btn btn-primary">Elimina</button>
=======
                           <tr>
                               <td>
                                   <form method="post" action="" enctype="multipart/form-data">
                                       @method('DELETE')
                                       @csrf
                                       <button type="submit" class="btn btn-primary">Delete</button>
                                       <a class="btn btn-primary" href="{{ route('posts.edit',$post) }}" role="button">Upadte</a>
                                       <a class="btn btn-primary" href="{{ url('/posts') }}" role="button">Index</a> 
>>>>>>> b627786e05fe698bceb88954df9a3b03ddb84c5a
                                    </form>
                                </td>
                                <td class="noborder">
                                    @if($is_like == false)
                                        <form method="post" action="{{ route('posts.likes',$post) }}" >
                                            @csrf 
                                            <button class=" btn btn-primary"><img class="cor"src ="../../images/corazon2.png"></button>
                                        </form>
                                    @else
                                        <form method="post" action="{{ route('posts.unlike',$post) }}" >
                                            @csrf 
                                            @method('DELETE')
                                            <button class="btn-focus btn btn-primary"><img class="cor"src ="../../images/corazon.png"></button>
                                        </form>
                                    @endif
                                </td>  
                            </tr>
                       </tbody>
                   </table>
                   
               </div>
           </div>
       </div>
   </div>
</div>
@endsection