<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function index2()
    {
        $proyectos = Proyecto::all();
        $opcion = true;

        $contador = 1;
        $array = array();
        $arrays = array();
        foreach ($proyectos as $proyecto) {
            print($proyecto->nombre);
            print($contador);
            if ($contador <= 2) {
                array_push($array, $proyecto);
            } else {
                array_push($arrays, $array);
                $array = array();
                $contador = 1;
            }
            $contador = $contador + 1;
        }
        array_push($arrays, $array);
        dd($arrays);
        return view('hom2', compact('arrays', 'opcion'));
    }
}
