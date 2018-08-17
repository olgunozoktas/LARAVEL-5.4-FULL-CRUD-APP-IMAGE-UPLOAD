@extends('layouts.app')
@section('content')
    <h1>Create Post</h1>
    <!-- when submitted will call the store function in PostsController -->
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
                         <!-- name , value , attribute -->
            {{Form::label('title','Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title Text'])}}
        </div>
        <div class="form-group">
            <!-- name , value , attribute -->
            {{Form::label('body','Body')}}
            {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection