
@extends('layouts.app')
@env(['local','development'])
   @vite('resources/js/files/create.js')
@endenv

 @section('content')
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="cardForms">
                <div class="card-header">{{ __(' Ad new file') }}</div>
                <div class="card-body">
                    <form id = "create" method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload"/>
                            <div id= "alert"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
           </div>
       </div>
   </div>
</div>
@endsection