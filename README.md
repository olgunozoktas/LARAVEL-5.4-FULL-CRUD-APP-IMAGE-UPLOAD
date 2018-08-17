# Laravel 5.4 FULL - CRUD APP WITH AN IMAGE UPLOAD

~~~~

Examples of Artisan commands

php artisan list -> show all available commands
php artisan help `name` -> show speficic information about command for example php artisan help migrate
php artisan make:controller TodosController -> to create an controller
php artisan make:model Todo -m -> to create an model and (-m) means migration as well
php artisan make:migration add_todos_to_db-table=todos -> create migration
php artisan migrate
php artisan tinker -> interact with db

Eloquent ORM

Object Relational Mapper

- Makes querying & working with the DB very easy
- We can still use raw SQL queries if needed

Example:

Use App\Todo;
$todo = new Todo;
$todo->title = 'Some Todo';
$todo->save();

Blade Template Engine

- Simple & powerful
- Control structures (if else, loops, etc)
- Can use <?php echo 'PHP Tas'; ?>
- Template Inheritance: Extend layouts easily
- Can create custom components

Example:

<!-- stored in resources/views/layouts/app.blade.php -->

<html>
    <head>
        <title> App Name - @yield('title')</title>
    </head>
    
    <body>
        @section('sidebar')
            This is the master sidebar
        @showt
        
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

<!-- stored in resources/views/child.blade.php -->

@extends('layouts.app')

@section('title, 'Page Title')

@section('sidebar')
    @parent
    
    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p> This is my body content.</p>
@endsection
~~~~~

## Lets Create laravel app

composer create-project laravel/laravel lsapp

If Composer not installed then Go To [Composer][1]:

[1]: https://getcomposer.org

## How to RUN Laravel App Securely?

1. Go To xampp/apache/conf/extra/httpd-vhosts.conf

Add those lines

<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs"
    ServerName localhost
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "path_of_laravel_app/public"
    ServerName lsapp.me <!-- Your app name --> (.dev, .net  those may not work)
</VirtualHost>

2. Open Notepad as an Administrator and go to C:\Windows\System32\drivers\etc

Open File hosts and end of the file

Add those lines

127.0.0.1 localhost
127.0.0.1 lsapp.me <!-- Your VirtualHost app name --> 

3. Restart Apache Server

## How to return a html file?

`return view('name_of_the_file');`

## Lets create a folder in resources/views/pages

In this folder we will create our pages

about.blade.php

GET Request: /about -> will return about page

For this purpose in routes/web.php 

Add those lines

~~~~

Route::get('/about', function() { return view('pages/about'); });
                                            or pages.about -> Both are pretty much same 
                                            
~~~~        

## Lets create Controller

~~~~
php artisan make:controller PagesController
                            //pascal case means First Letters of words are upper case

~~~~

## How to call a function from controller in web.php?

`Route::get('/', 'PagesController@index');`

~~~~

PagesController -> index function

    public function index() {
        return view('pages.index');
    }

~~~~~ 

## How to pass a value to view from function?

~~~~
    
    public function index() {
        $title = "Welcome To Laravel!";
        return view('pages.index')->with('title', $title);
    }
    
    Other Method is
    
    public function index() {
        $title = "Welcome To Laravel!";
        return view('pages.index', compact('title'));
    } 
    
    
    In the view get it like that
    
    <h1>{{$title}}</h1>   
~~~~

## How to pass an array to the view from function?

~~~~

    public function services() {

        //To send an array
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.services')->with($data); //if it is array then do not need to write a identifier
    }
    
    In the view how get array values?
    
    @extends('layouts.app')
    @section('content')
        <h1>{{$title}}</h1>
        @if(count($services) > 0)
            @foreach($services as $service)
                <li>{{$service}}</li>
            @endforeach
        @endif
    @endsection
~~~~

## How to install dependencies on package.json?

npm install

## How to compile changes in resources/assets/sass?

npm run dev -> everytime

instead make it automatically

npm run watch -> if there is any change it will recompile them automatically

## Where are the compiled files? -> In the public folder

## How to create custom scss?

1. Go to resources/assets/sass 
2. Create scss file and put your scss inside
3. Go to app.scss
4. Add those line @import "filename" -> ex @import "custom";

## Lets Create a controller for Posts

~~~~
php artisan make:controller PostsController //this will create an empty conroller file

to create an posts contoller with the functions index,store,edit,update,show,delete

php artisan make:controller PostsController --resource

~~~~~

## Lets Create a model and migration for Posts

`php artisan make:model Post -m`

## Lets Make some changes on migration for posts

1. Go To database/migrations/create_posts_table.php which is the migration file for posts
2. Add Those Lines

~~~~
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title'); //string is default 50 or more characters and it will give us an error so lets change it
            $table->mediumText('body');
            $table->timestamps();
        });
    }
    
    To change string default length
    
    Go to app/Providers/AppServiceProvider.php
    
    and add Those lines
    
    use Illuminate\Support\Facades\Schema;
    
    then go to boot() function and add those lines
    
    Schema::defaultStringLength(191); 
    
    Thats all
~~~~    

## Lets migrate our db

~~~~ 
php artisan migrate 
~~~~

## Lets use tinker to insert, select, update data in db

~~~~

php artisan tinker

Example usage:

App\Post::count(); -> to see how many posts are there in the db

To create a new post

$post = new App\Post();

$post->title = 'Post One';
$post->body = 'This is the post body';
$post->save() -> to insert to db

To create another new post

$post = new App\Post();

$post->title = 'Post Two';
$post->body = 'This is the post two body';
$post->save() -> to insert to db -> return true if successfull

~~~~

## To see what routes we have in the app

~~~~

php atisan route:list


~~~~

## To create routes for each posts functions

~~~~

Add this line to routes

Route::resources('posts', 'PostsController');

~~~~~

## Post Controller

~~~~

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB; //TO USE SQL QUERIES

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Eloquent -> Object Relational Model function
        //$posts = Post::all(); -> will bring all of them
        //$posts = Post::orderBy('title', 'desc')->get();
        //$posts = Post::orderBy('title', 'desc')->take(1)->get(); //will return 1 post
        //To find individual post in another way
        //$post  = Post::where('title','Post Two')->get();

        /* TO USE DB LIBRARY TO WRITE PURE SQL

            $posts = DB::select('SELECT * FROM POSTS');
        */

        $posts = Post::orderBy('title','desc')->paginate(1); //to paginate
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

~~~~

## Create posts folder under resources/views/posts

Add Those 2 files

1.index.blade.php
2.show.blade.php

~~~~

index.blade.php

@extends('layouts.app')
@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card card-body bg-light" style="margin-bottom: 15px">
                <h3 class="card-title"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
                <small class="card-text">Written on {{$post->created_at}}</small>
            </div>
         @endforeach
        {{$posts->links()}}
    @else
        <p>No posts found</p>
    @endif
@endsection

show.blade.php

@extends('layouts.app')
@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
    <div>
        {{$post->body}}
    </div>
    <hr>
    <small>Written on {{$post->created_at}}</small>
@endsection

~~~~

## Lets Use Collective Plugin to use Laravel Forms

~~~~

composer require "laravelcollective/html":"^5.4.0"

Then go to config/app.php

Add this line to the bottom of the Providers array

Collective\Html\HtmlServiceProvider::class,

Then in the same file add those lines ot the bottom of the aliases array

'Form' => Collective\Html\FormFacade::class,
'Html' => Collective\Html\HtmlFacade::class,

~~~~

## Add create file to the views/posts

~~~~

In the file add those lines to use laravel built-in form plugin

@extends('layouts.app')
@section('content')
    <h1>Create Post</h1>
    <!-- when submitted will call the store function in PostsController -->
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST']) !!}
        <div class="form-group">
                         <!-- name , value , attribute -->
            {{Form::label('title','Title')}}
            {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title Text'])}}
        </div>
        <div class="form-group">
            <!-- name , value , attribute -->
            {{Form::label('body','Body')}}
            {{Form::textarea('body', '', ['class' => 'form-control', 'placeholder' => 'Body Text'])}}
        </div>
        {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection

~~~~

## Store function and other changes in PostsController

~~~~

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB; //TO USE SQL QUERIES

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Eloquent -> Object Relational Model function
        //$posts = Post::all(); -> will bring all of them
        $posts = Post::orderBy('created_at', 'desc')->get();
        //$posts = Post::orderBy('title', 'desc')->take(1)->get(); //will return 1 post
        //To find individual post in another way
        //$post  = Post::where('title','Post Two')->get();

        /* TO USE DB LIBRARY TO WRITE PURE SQL

            $posts = DB::select('SELECT * FROM POSTS');
        */

        //$posts = Post::orderBy('title','desc')->paginate(1); //to paginate
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // Create Posts -> we called use App\Post; that is why just new Post is enough;
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

~~~~

## Create a file called messages in the resources/inc

Add those lines to the file

~~~~

This is going to be used to show messages if the form is submitted successfully

@if(count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif

~~~~

## Some changes in resources/views/layouts/app.blade.php

~~~~

    <div class="container">
        @include('inc.messages') <!-- To show error or success messages after form submitted -->
        @yield('content')
    </div>

~~~~

## How to use CkEditor in Laravel?

1. Go to https://github.com/UniSharp/laravel-ckeditor
2. composer require unisharp/laravel-ckeditor
3. Add providers to the config/app.php

~~~~

Unisharp\Ckeditor\ServiceProvider::class,

~~~~

4. Publish the resources

~~~~

php artisan vendor:publish --tag=ckeditor

~~~~

5. To use ckEditor go to layout/app.blade.php
6. Add those lines EO Body tag

~~~~

    <script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'article-ckeditor' );
    </script>
    
~~~~

7. To use this editor go to resources/views/posts/create.blade.php

Add those attribute to the textarea

~~~~

    {{Form::textarea('body', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Body Text'])}}

~~~~

Thats all for ck editor

## How to parse CkEditor html?

Go to show.blade.php and change two curly braces with

~~~~

{!!$post->body!!}

~~~~

Now it will be parse the html successfully

## How to Update a post?

1. Create a new file called edit in the resources/views/posts

Add those lines to the file

~~~~

@extends('layouts.app')
@section('content')
    <h1>Eidt Post</h1>
    <!-- when submitted will call the update function in PostsController and send $post->id -->
    {!! Form::open(['action' => ['PostsController@update', $post->id], 'method' => 'POST']) !!}
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
    <!-- is the way to send put request which is used to update -->
    {{Form::hidden('_method', 'PUT')}}
    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection

~~~~

2. In the show.blade.php add those lines

~~~~
    <!-- To go edit page-->
    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
~~~~

3. In the PostsController add those lines to the edit and update function

~~~~

    public function edit($id)
    {
        $post = Post::find($id);
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }
    
~~~~

## How to delete a post?

1. In the resources/views/posts/show.blade.php add those lines

~~~~

    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {{Form::Hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}

~~~~

2. In the PostsController.php add those lines

~~~~

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
~~~~

## How to authenticate users?

~~~~

php artisan make:auth

If would like to change the name of the Controller which is HomeController
Change its name in everywhere

~~~~

## How to add a new column to the posts table?

~~~~

php artisan make:migrate add_user_id_to_posts

this will create a migration

then move on to this migration and write those lines

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // when we call php artisan migrate -> it will add this line
        Schema::table('posts', function($table){
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // when we call php artisan migrate:rollback it will delete this column
        Schema::table('posts', function($table){
            $table->dropColumn('user_id');
        });
    }
}

~~~~

## How to make a relationship with models??

~~~~

post Model ----

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //User has a post
    public function user(){
        return $this->belongsTo('App\User');
    }
}


user Model ---- 

<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    //User have many posts because can have more than one
    public function posts(){
        return $this->hasMany('App\Post');
    }
}

~~~~

## DashBoard Controller to return the posts of the user?

~~~~

    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);               //posts function in user
        return view('dashboard')->with('posts', $user->posts);
    }

~~~~

## How to restrict the users guest to edit or delete post

Add those line to PostsContoller.php

~~~~

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {                               //it wills show index page and show page its okey
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
 
~~~~

Add those lines to the show.blade.php

~~~~

@extends('layouts.app')
@section('content')
    <a href="/posts" class="btn btn-default">Go Back</a>
    <h1>{{$post->title}}</h1>
    <div>
        {!!$post->body !!}
    </div>
    <hr>
    <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
    <!-- To go edit -->
    <a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>

    {!!Form::open(['action' => ['PostsController@destroy', $post->id], 'method' => 'POST', 'class' => 'float-right'])!!}
        {{Form::Hidden('_method', 'DELETE')}}
        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
    {!!Form::close()!!}
        @endif
    @endif
@endsection

~~~~

Add those lines to the PostsController.php to prevent user to edit or delete over url

~~~~

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use DB; //TO USE SQL QUERIES

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Eloquent -> Object Relational Model function
        //$posts = Post::all(); -> will bring all of them
        $posts = Post::orderBy('created_at', 'desc')->get();
        //$posts = Post::orderBy('title', 'desc')->take(1)->get(); //will return 1 post
        //To find individual post in another way
        //$post  = Post::where('title','Post Two')->get();

        /* TO USE DB LIBRARY TO WRITE PURE SQL

            $posts = DB::select('SELECT * FROM POSTS');
        */

        //$posts = Post::orderBy('title','desc')->paginate(1); //to paginate
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        // Create Posts -> we called use App\Post; that is why just new Post is enough;
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id; //to get the user_id
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //Check for correct user to go to the edit page from manuel url
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //Check for correct user to go to the edit page from manuel url
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }

        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
}

~~~~

## How To Upload File?

1. Create another migration to add cover_image column to the posts in db

php artisan make:migrate add_cover_image_to_posts

in this migration file add those lines

~~~~

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCoverImageToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function($table){
            $table->string('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table){
            $table->dropColumn('cover_image');
        });
    }
}

~~~~

2. Go to create.blade.php and add those lines

~~~~

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

~~~~

3. Lets link public folder with a storage folder

For this purpose run the following command

`php artisan storage:link` Whatever we put in o the storage it will be shown in public

4. To Upload or Delete Image Use Following Lines

~~~~

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;
use DB; //TO USE SQL QUERIES

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Eloquent -> Object Relational Model function
        //$posts = Post::all(); -> will bring all of them
        $posts = Post::orderBy('created_at', 'desc')->get();
        //$posts = Post::orderBy('title', 'desc')->take(1)->get(); //will return 1 post
        //To find individual post in another way
        //$post  = Post::where('title','Post Two')->get();

        /* TO USE DB LIBRARY TO WRITE PURE SQL

            $posts = DB::select('SELECT * FROM POSTS');
        */

        //$posts = Post::orderBy('title','desc')->paginate(1); //to paginate
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999' //means it can be image or null value but max:2mb because apache server accepts 2 mb file upload
        ]);

        //Handle File Upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        // Create Posts -> we called use App\Post; that is why just new Post is enough;
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id; //to get the user_id
        $post->cover_image = $fileNameToStore;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post',$post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //Check for correct user to go to the edit page from manuel url
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        //Handle File Upload
        if($request->hasFile('cover_image')){
            // Get filename with the extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        $post = Post::find($id);

        if($post->cover_image != 'noimage.jpg'){
            //Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        //Check for correct user to go to the edit page from manuel url
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error','Unauthorized Page');
        }

        if($post->cover_image != 'noimage.jpg'){
            //Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();
        return redirect('/posts')->with('success','Post Removed');
    }
}

~~~~
