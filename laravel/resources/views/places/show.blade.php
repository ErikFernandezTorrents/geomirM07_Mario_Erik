@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="cardForms">
            <div class="card-header"><p>{{ $place->author->name}}</p></div>
               <div class="card-body">
                   <table class="table">
                       <tbody>
                            <tr>
                               <td scope="col">Name</td>
                               <td>{{ $place->name }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Latitude</td>
                               <td>{{ $place->latitude }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Longitude</td>
                               <td>{{ $place->longitude }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Created</td>
                               <td>{{ $place->created_at }}</td>
                           </tr>
                           <tr>
                                <td colspan="2" aling="center"><img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                           </tr>
                       </tbody>
                       <tr>
                            <td><a class="btn btn-primary" href="{{ route('places.edit',$place) }}" role="button">Editar</a></td>
                            <td><a class="btn btn-primary" href="{{ route('places.index') }}" role="button">Index</a></td>
                            <td>
                                <form method="post" action="{{ route('places.destroy',$place) }}" >
                                    @csrf     
                                    @method('DELETE')
                                            
                                    <button class="btn btn-primary">Elimina</button>
                                </form>
                            </td>
                            <td class="noborder">
                                @if($is_favourite == false)
                                    <form method="post" action="{{ route('places.favourites',$place) }}" >
                                        @csrf 
                                        <button class=" btn btn-primary"><img class="cor"src ="../../images/estrella2.png"></button>
                                    </form>
                                @else
                                    <form method="post" action="{{ route('places.unfavourite',$place) }}" >
                                        @csrf 
                                        @method('DELETE')
                                        <button class="btn-focus btn btn-primary"><img class="cor"src ="../../images/estrella.png"></button>
                                    </form>
                                @endif
                            </td>                 
                        </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection