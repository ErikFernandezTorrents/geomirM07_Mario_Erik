@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="cardForms">
               <div class="card-header">{{ $place->name }}</div>
               <div class="card-body">
               <table class="table">
                       <thead>
                       <form method="post" action="{{ route('places.update', $place) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload" value="{{ asset('storage/{$file->filepath}') }}"/>
                            <label for="name">Name:</label>
                            <input type="txt" class="form-control" name="name" value='{{ $place->name }}' />
                            <label for="description">Description:</label>
                            <input type="txt" class="form-control" name="description" value='{{ $place->description }}'/>
                            <label for="latitude">Latitude:</label>
                            <input type="txt" class="form-control" name="latitude" value='{{ $place->latitude }}' />
                            <label for="longitude">Longitude:</label>
                            <input type="txt" class="form-control" name="longitude" value='{{ $place->longitude }}'/>
                            <div> 
                                <label for="visibility_id">Visibility</label>
                                <select name="visibility_id" class="form-control">
                                @foreach( $visibilities as $visibility)
                                    <option value="{{__($visibility->id)}}">{{__($visibility->name)}}</option>
                                @endforeach    
                                </select>                   
                            </div>
                            <p></p>
                            <button type="submit" class="btn btn-secondary">Edit</button>
                        </div>
                        
                        </form>
                       </thead>
                       
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
