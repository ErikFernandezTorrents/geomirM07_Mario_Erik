@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __(' Add new place') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('place.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="upload">Name:</label>
                            <input type="text" class="form-control" name="name"/>
                            <label for="upload">Description:</label>
                            <input type="text" class="form-control" name="description"/>
                            <label for="upload">Latitude:</label>
                            <input type="text" class="form-control" name="latitude"/>
                            <label for="upload">Longitude:</label>
                            <input type="text" class="form-control" name="longitude"/>
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload"/>
                        </div>
                        <p></p>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection