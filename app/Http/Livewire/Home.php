<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Proyecto;
use App\Models\ProyectoUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Home extends Component
{
    public $nombre, $descripcion, $proyecto_id, $codigo;
    public $users;

    public $modalCrear = false;
    public $modalEdit = false;
    public $errormodal = false;
    public $modalDestroy = false;
    public $modalUnirse = false;
    public $modalCompartir = false;
    public $modalUsers = false;
    public $registrado = false;
    public $opcion = true;
    public $contador = 0;
    public $longitud = 0;

    public function contar()
    {
        if ($this->contador < $this->longitud - 1) {
            $this->contador = $this->contador + 1;
        }
    }
    public function restar()
    {
        if ($this->contador > 0) {
            $this->contador = $this->contador - 1;
        }
    }

    public function render()
    {
        $user = User::find(Auth()->user()->id);
        if ($this->opcion) {
            $proyectos = $user->proyecto;

        } else {
            $proyectos = $user->proyectos;
        }

        return view('livewire.home', compact('proyectos'));
    }

    public function verProyecto($proyecto_id)
    {
        $this->proyecto_id = $proyecto_id;
        $this->users = DB::table('users')
            ->join('proyecto_user', 'proyecto_user.user_id', '=', 'users.id')
            ->where('proyecto_user.proyecto_id', $proyecto_id)
            ->select('users.id', 'users.name', 'users.email', 'proyecto_user.proyecto_id')
            ->get();
        $this->modalUsers = true;
    }

    public function actualizarVerUsers($proyecto_id)
    {
        $this->users = DB::table('users')
            ->join('proyecto_user', 'proyecto_user.user_id', '=', 'users.id')
            ->where('proyecto_user.proyecto_id', $proyecto_id)
            ->select('users.id', 'users.name', 'users.email', 'proyecto_user.proyecto_id')
            ->get();
    }

    public function compartirProyecto($codigo)
    {
        $this->modalCompartir = true;
        $this->codigo = $codigo;
    }

    public function storeProyecto()
    {
        if ($this->nombre != "") {
            $this->errormodal = false;
            do {
                $token = Str::uuid();
            } while (Proyecto::where("codigo", $token)->first() instanceof Proyecto);

            Proyecto::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'user_id' => Auth()->user()->id,
                'codigo' => Str::uuid(),
            ]);
            $this->limpiar();
        } else {
            $this->errormodal = true;
        }
    }

    public function unirseProyecto()
    {
        if ($this->codigo == "") {
            $this->errormodal = true;
        } else {
            $proyecto = Proyecto::where("codigo", $this->codigo)->get()->first();
            $proyectouser = ProyectoUser::where("user_id", auth()->user()->id)
                ->where("proyecto_id", $proyecto->id)
                ->get()->first();
            if ($proyecto && $proyectouser == null) {
                $proyecto->users()->attach(auth()->user()->id);
                $this->registrado = false;
                $this->limpiar();
            } else {
                $this->errormodal = true;
                $this->registrado = true;
            }
        }
    }
    public function updateProyecto()
    {
        if ($this->nombre == "") {
            $this->errormodal = true;
        } else {
            $proyecto = Proyecto::find($this->proyecto_id);
            $proyecto->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
            ]);
            $this->limpiar();
        }
    }

    public function modalEdit($id)
    {
        $this->modalEdit = true;
        $this->proyecto_id = $id;
        $proyecto = Proyecto::find($this->proyecto_id);
        $this->nombre = $proyecto->nombre;
        $this->descripcion = $proyecto->descripcion;
    }

    public function limpiar()
    {
        $this->nombre = null;
        $this->descripcion = null;
        $this->modalEdit = false;
        $this->modalCrear = false;
        $this->modalDestroy = false;
        $this->modalUnirse = false;
        $this->codigo = null;
        $this->modalCompartir = false;
        $this->errormodal = false;
        $this->modalUsers = false;

    }
    public function cancelar()
    {
        $this->limpiar();
    }

    public function modalDestroy($id)
    {
        $this->modalDestroy = true;
        $this->proyecto_id = $id;
    }

    public function destroyProyecto()
    {
        $tipocuenta = Proyecto::find($this->proyecto_id);
        $tipocuenta->delete();
        $this->modalDestroy = false;
        $this->limpiar();
    }

    public function destroyProyectouser($user, $proyecto)
    {
        $proyectouser = ProyectoUser::where("user_id", $user)
            ->where("proyecto_id", $proyecto)
            ->get()->first();
        $proyectouser->delete();
        $this->actualizarverusers($proyecto);
    }
}
