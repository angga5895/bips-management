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

        $clapp = DB::select(' SELECT cl_app_mod.*, cl_app.*, cl_module.* FROM cl_app
                                LEFT JOIN cl_app_mod ON cl_app.cla_id = cl_app_mod.clam_cla_id
                                LEFT JOIN cl_module ON cl_module.clm_id = cl_app_mod.clam_clm_id
                                JOIN cl_permission_app_mod ON cl_permission_app_mod.clp_app_mod = cl_app_mod.id
                                ORDER BY cl_app.cla_order;');

        $cl_app = DB::select('SELECT cl_app.* FROM cl_app JOIN cl_permission_app ON cl_permission_app.clp_app = cl_app.cla_id ORDER BY cl_app.cla_order;');

        return view('home', ['title' => 'Dashboard', 'countgroup'=>$countgroup, 'clapp' => $clapp, 'cl_app' => $cl_app]);
    }
}
