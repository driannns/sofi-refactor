<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GBController extends Controller
{
    public function student(){
        return view('guidebook.guide_book_student');
    }
    public function admin(){
        return view('guidebook.guide_book_admin');
    }
    public function pembimbing(){
        return view('guidebook.guide_book_pembimbing');
    }
    public function PIC(){
        return view('guidebook.guide_book_PIC');
    }
}
