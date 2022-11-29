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
                                <td scope="col">Body</td>
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
                           <tr >
                                <td><a class="btn btn-primary noborder" href="{{ route('posts.edit',$post) }}" role="button">Editar</a></td>
                                <td><a class="btn btn-primary noborder" href="{{ url('/posts') }}" role="button">Index</a></td>
                                <td class="noborder">
                                    <form method="post" action="{{ route('posts.destroy',$post) }}" >
                                        @csrf     
                                        @method('DELETE')
                                            
                                        <button class="btn btn-primary">Elimina</button>
                                    </form>
                                </td>
                                <td class="noborder">
                                    @if($is_like == false)
                                        <form method="post" action="{{ route('posts.likes',$post) }}" >
                                            @csrf 
                                            <button class=" btn btn-primary"><img class="cor"src ="../../images/corazon2.png">{{ $numLikes }}</button>
                                        </form>
                                        
                                    @else
                                        <form method="post" action="{{ route('posts.unlike',$post) }}" >
                                            @csrf 
                                            @method('DELETE')
                                            <button class="btn-focus btn btn-primary"><img class="cor"src ="../../images/corazon.png">{{ $numLikes }}</button>
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