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
                            <div class="card-header">{{ __('fields.places') }} de @Erik</div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="noborder">{{ $place->author->name}}</td>
                                            </tr>
                                        </thead>
                                        <tbody>      
                                            <tr>
                                                <td class="noborder" aling="center"><img id="placeIMG" src="{{ asset("storage/{$place->file->filepath}") }}" /></td>
                                            </tr>
                                            <tr>
                                                <td class="noborder">{{__('fields.created')}}</td>
                                            </tr>
                                            <tr >
                                                <td class="noborder">{{ $place->created_at }}</td> 
                                            </tr>
                                            <tr>
                                                <td class="noborder">
                                                    <form method="post" action="{{ route('places.favourites',$place) }}" >
                                                        @csrf 
                                                        <a href="https://icons8.com/icon/5TRav1-SpMcu/corazón-de-fuego"></a>
                                                    </form>
                                                </td>
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