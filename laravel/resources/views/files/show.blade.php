@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="cardForms">
               <div class="card-header">{{ __('Info file') }}</div>
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
                               <td>{{ $file->id }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Filepath</td>
                               <td>{{ $file->filepath }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Filesize</td>
                               <td>{{ $file->filesize }}</td>
                            </tr>
                            <tr>
                               <td scope="col">Created</td>
                               <td>{{ $file->created_at }}</td>
                           </tr>
                           <tr>
                               <td scope="col">Updated</td>
                               <td>{{ $file->updated_at }}</td>
                           </tr>
                           <tr>
                                <td colspan="2" aling="center"><img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td>
                           </tr>
                       </tbody>
                       <tr>
                            <td><a class="btn btn-primary" href="{{ route('files.edit',$file) }}" role="button">Editar</a></td>
                            <td>
                                <form method="post" action="{{ route('files.destroy',$file) }}" >
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