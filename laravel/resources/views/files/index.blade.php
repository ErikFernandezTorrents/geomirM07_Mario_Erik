@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="cardForms">
               <div class="card-header">{{ __('Files') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">{{__('fields.file_id')}}</td>
                               <td scope="col">{{__('fields.Filepath')}}</td>
                               <td scope="col">{{__('fields.Filesize')}}</td>
                               <td scope="col">{{__('fields.Created')}}</td>
                               <td scope="col">{{__('fields.Uploated')}}</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($files as $file)
                           <tr>
                           <td><a href="{{ route('files.show',$file) }}">{{ $file->id }}</a></td>
                               <td>{{ $file->filepath }}</td>
                               <td>{{ $file->filesize }}</td>
                               <td>{{ $file->created_at }}</td>
                               <td>{{ $file->updated_at }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-secondary" href="{{ route('files.create') }}" role="button">Add new file</a>
                   <a class="btn btn-secondary" href="{{ url('/dashboard') }}" role="button">Home</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection