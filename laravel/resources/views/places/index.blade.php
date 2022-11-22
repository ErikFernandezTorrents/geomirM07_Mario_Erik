@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Files') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">{{__('fields.file_id')}}</td>
                               <td scope="col">{{__('fields.name')}}</td>
                               <td scope="col">{{__('fields.description')}}</td>
                               <td scope="col">{{__('fields.file_id')}}</td>
                               <td scope="col">{{__('fields.latitude')}}</td>
                               <td scope="col">{{__('fields.longitude')}}</td>
                               <td scope="col">{{__('fields.created')}}</td>
                               <td scope="col">{{__('fields.uploated')}}</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($place as $place)
                           <tr>
                           <td><a href="{{ route('places.show',$place) }}">{{ $place->id }}</a></td>
                               <td>{{ $place->name }}</td>
                               <td>{{ $place->description }}</td>
                               <td>{{ $place->file_id }}</td>
                               <td>{{ $place->latitude }}</td>
                               <td>{{ $place->longitude }}</td>
                               <td>{{ $place->created_at }}</td>
                               <td>{{ $place->updated_at }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
                   <a class="btn btn-primary" href="{{ url('/dashboard') }}" role="button">Home</a> 
               </div>
           </div>
       </div>
   </div>
</div>
@endsection