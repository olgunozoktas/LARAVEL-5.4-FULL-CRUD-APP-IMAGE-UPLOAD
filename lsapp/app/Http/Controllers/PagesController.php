<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index() {
        $title = "Welcome To Laravel!";
        return view('pages.index')->with('title', $title);
    }

    public function about() {
        $about = 'About Us';
        return view('pages.about')->with('about', $about);
    }

    public function services() {

        //To send an array
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design', 'Programming', 'SEO']
        );
        return view('pages.services')->with($data);
    }
}
