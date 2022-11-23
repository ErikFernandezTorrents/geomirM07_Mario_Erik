@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __(' Add new place') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
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
                            <tr>
                                <td>
                                    <label for="visibility_id">Visibility</label>
                                    <select name="visibility_id" class="form-control">
                                        <option value="1">public</option>
                                        <option value="2">contacts</option>   
                                        <option value="3">private</option> 
                                    </select>                                           
                                </td>
                            </tr>
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