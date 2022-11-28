@extends('layouts.app')

@section('content')
    <div class="addPost">
        <a class="btn btn-primary" href="{{ route('posts.create') }}" role="button">Add new post</a>
        <a class="btn btn-primary" href="{{ url('/dashboard') }}" role="button">Home</a> 
    </div>
    @foreach ($posts as $post)
        <div class="container">
            <div> 
                    <a id="postshow" href="{{ route('posts.show',$post) }}">
                        <div class="card">
                            <div class="card-header"><p class="blanco">{{ $post->author->name}}</p></div>
                                <div class="card-body">
                                    <table class="table">
                                
                                        <tbody class="Centrar">
                                            <tr>
                                                <td class="noborder" aling="center"><img id="postIMG" src="{{ asset("storage/{$post->file->filepath}") }}" /></td>
                                            </tr>
                                            <tr>
                                                <td class="noborder">{{__('fields.created')}}</td>
                                            </tr>
                                            <tr >
                                                <td class="noborder">{{ $post->created_at }}</td> 
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </a> 
                        <div class="cardDescription">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr id="descriptionHeader">
                                            <td class="noborder" >{{__('fields.body')}}</td>
                                        </tr>
                                    </thead>
                                    <tbody>      
                                        <tr>
                                            <td class="noborder">{{ $post->body }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>  
            </div>
        </div>
    @endforeach
@endsection