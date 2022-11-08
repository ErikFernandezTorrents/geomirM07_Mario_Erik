@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Post') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">ID</td>
                               <td scope="col">Body</td>
                               <td scope="col">Latitude</td>
                               <td scope="col">Longitude</td>
                               <td scope="col">Created at</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($posts as $post)
                           <tr>
                           <td><a href="{{ route('posts.show',$post) }}">{{ $post->id }}</a></td>
                               <td>{{ $post->body }}</td>
                               <td>{{ $post->latitude }}</td>
                               <td>{{ $post->longitud }}</td>
                               <td>{{ $post->created_at }}</td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-primary" href="{{ route('posts.create') }}" role="button">Add new post</a>
                   <a class="btn btn-primary" href="{{ url('/dashboard') }}" role="button">Home</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection