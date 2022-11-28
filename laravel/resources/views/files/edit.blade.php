@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="cardForms">
               <div class="card-header">{{ __('Info file: ') }}{{ $file->id }}</div>
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
                                <td colspan="2">
                                    <div class="card-body">
                                            <form method="post" action="{{ route('files.update', $file) }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="upload">File:</label>
                                                    <input type="file" class="form-control" name="upload"/>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Editar</button>
                                                <button type="reset" class="btn btn-secondary">Reset</button>
                                                @method('PUT')
                                            </form>
                                    </div>
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