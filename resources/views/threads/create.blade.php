@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create A Thread</div>

                <div class="card-body">
                    <form action="/threads" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Post Thread</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection