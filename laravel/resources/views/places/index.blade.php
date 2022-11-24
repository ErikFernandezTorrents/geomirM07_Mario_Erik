@extends('layouts.app')
 
@section('content')
<div class="container">
   <div>
        <div class="addPlace">
            <a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
            <a class="btn btn-primary" href="{{ url('/dashboard') }}" role="button">Home</a> 
        </div>
            @foreach ($place as $place)
                <a id="placeShow" href="{{ route('places.show',$place) }}">
                    <div class="card">
                        <div class="card-header">{{ __('fields.places') }} de @Erik</div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="noborder">@Erik</td>
                                            <td class="noborder">{{__('fields.description')}}</td>
                                        </tr>
                                    </thead>
                                    <tbody>      
                                        <tr>
                                            <td class="noborder"><img class="logo" src="../images/logo_geomir.png"></img></td>
                                            <td class="noborder">{{ $place->description }}</td>
                                        </tr>
                                        <tr>
                                            <td class="noborder">{{__('fields.created')}}</td>
                                        </tr>
                                        <tr >
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
                                <tr>
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
            @endforeach
    </div>
</div>
@endsection