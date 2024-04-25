<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user($token)
    {

        $user = User::Where("token", $token)
            ->select("name", "email", "token")
            ->get()->first();
        if ($user) {
            return $user;
        }
        return "Token no valido";
    }

    public function guardar(Request $request, $codigo)
    {

        $proyecto = Proyecto::Where('codigo', $codigo)
            ->get()->first();
        if ($proyecto) {
            $proyecto->update([
                'content' => $request->content,
            ]);
            return "guardado";
        }
        return "hubo un error";
    }

    public function cargarDiagrama($codigo)
    {

        $proyecto = Proyecto::Where('codigo', $codigo)
            ->get()->first();
        if ($proyecto) {
            return $proyecto;
        }
        return "Codigo no registrado";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // Validación de archivo
        $request->validate([
            'archivo' => 'required|file|mimes:xml,png|max:2048', // Cambia las extensiones y el tamaño máximo según tus necesidades
        ]);

        // Guardar el archivo en el sistema de archivos del servidor
        $archivo = $request->file('archivo');
        $nombreArchivo = $archivo->getClientOriginalName();
        $archivo->storeAs('archivos', $nombreArchivo); // Almacena el archivo en la carpeta 'archivos'

        return response()->json(['message' => 'Archivo guardado con éxito']);
    }
}
