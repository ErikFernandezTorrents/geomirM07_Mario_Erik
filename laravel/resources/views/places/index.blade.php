@extends('layouts.app')

@section('content')
    <div class="addPlace">
        <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
        <a class="btn btn-primary" href="{{ url('/dashboard') }}" role="button">Home</a> 
    </div>
    @foreach ($place as $place)
        <div class="container">
            <div> 
                    <a id="placeShow" href="{{ route('places.show',$place) }}">
                        <div class="card">
                            <div class="card-header"><p>{{ $place->author->name}}</p></div>
                                <div class="body-card">
                                    <table class="table">
                                        <tbody id="tbodyIndex">      
                                            <tr>
                                                <td class="noborder"><img id="placeIMG" src="{{ asset("storage/{$place->file->filepath}") }}" /></td>
                                            </tr>
                                            <tr class="trCreated">
                                                <td class="noborder">{{__('fields.created')}}</td>
                                            </tr>
                                            <tr class="trCreated">
                                                <td class="noborder">{{ $place->created_at }}</td> 
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
                                            <td class="noborder">{{__('fields.description')}}</td>
                                        </tr>
                                    </thead>
                                    <tbody>      
                                        <tr>
                                            <td class="noborder">{{ $place->description }}</td>
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