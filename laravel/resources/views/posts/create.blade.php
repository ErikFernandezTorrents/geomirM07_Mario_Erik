@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="cardForms">
                <div class="card-header">{{ __('Ad new post') }}</div>
                <div class="card-body">
                <form method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <tr>
                                <td id="body">
                                    <label for="upload">Body:</label>
                                    <input type="text" class="form-control" name="body"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td id="latitude">
                                    <label for="upload">Latitude:</label>
                                    <input type="text" class="form-control" name="latitude"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td id="longitude">
                                    <label for="upload">Longitude:</label>
                                    <input type="text" class="form-control" name="longitude"/>
                                    <div class="error alert alert-danger alert-dismissible fade"></div>
                                </td>
                            </tr>
                            <tr>
                                <td id="visibility">
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