<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        dd(Auth::check());
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $query = 'select count(*) FROM "group"';
        $sql = DB::select($query);
        $countgroup = '';
        foreach ($sql as $p){
            $countgroup = $p->count;
        }
        return view('home', ['title' => 'Register', 'countgroup'=>$countgroup]);
    }
}
