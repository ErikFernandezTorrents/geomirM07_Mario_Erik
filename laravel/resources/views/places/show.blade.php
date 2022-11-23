@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Info Place') }}</div>
               <div class="card-body">
                   <table class="table">
                       <!-- <thead>
                           <tr>
                               <td scope="col">ID</td>
                               <td scope="col">Filepath</td>
                               <td scope="col">Filesize</td>
                               <td scope="col">Created</td>
                               <td scope="col">Updated</td>
                           </tr>
                       </thead> -->
                       <tbody>
                           <tr>
                               <td scope="col">ID</td>
                               <td>{{ $place->id }}</td>
                            </tr>
                            <tr>
                                <td scope="col">Author:</td>
                                <td>{{ $user->name }}</td> 
                           </tr>
                            <tr>
                               <td scope="col">Created</td>
                               <td>{{ $place->file_id }}</td>
                           </tr>
                            <tr>
                               <td scope="col">Name</td>
                               <td>{{ $place->name }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Description</td>
                               <td>{{ $place->description }}</td>
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
                               <td scope="col">Updated</td>
                               <td>{{ $place->updated_at }}</td>
                           </tr>
                           <tr>
                               <td scope="col">Visibiliry</td>
                               <td>{{ $place->visibility_id }}</td>
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
                        </tr>
                   </table>
                   
               </div>
           </div>
       </div>
   </div>
</div>
@endsection