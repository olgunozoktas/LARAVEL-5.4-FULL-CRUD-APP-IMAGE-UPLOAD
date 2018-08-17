@extends('layouts.app')
@section('content')
    <h1>Eidt Post</h1>
    <!-- when submitted will call the update function in PostsController and send $post->id -->
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="form-group">
        <!-- name , value , attribute -->
        {{Form::label('title','Title')}}
        {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title Text'])}}
    </div>
    <div class="form-group">
        <!-- name , value , attribute -->
        {{Form::label('body','Body')}}
        {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}
    </div>
    <div class="form-group">
        {{Form::file('cover_image')}}
    </div>
    <!-- is the way to send put request which is used to update -->
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection