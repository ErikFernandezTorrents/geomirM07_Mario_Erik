@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="cardForms">
                <div class="card-header">{{ __(' Add new place') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <tr>
                                <td>
                                    <label for="upload">Name:</label>
                                    <input type="text" class="form-control" name="name"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="upload">Description:</label>
                                    <input type="text" class="form-control" name="description"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="upload">Latitude:</label>
                                    <input type="text" class="form-control" name="latitude"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="upload">Longitude:</label>
                                    <input type="text" class="form-control" name="longitude"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="visibility_id">Visibility</label>
                                    <select name="visibility_id" class="form-control">
                                    @foreach( $visibilities as $visibility)
                                        <option value="{{__($visibility->id)}}">{{__($visibility->name)}}</option>
                                    @endforeach    
                                    </select>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>                   
                                </td>
                            </tr>
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload"/>
                            <div class="error alert alert-danger alert-dismissible fade"></div>
                        </div>
                        <p></p>
                        <button type="submit" class="btn btn-secondary">Create</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection