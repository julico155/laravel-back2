<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $table="proyectos";
    protected $guarded=['id','created_at','updated_at'];

    //relacion uno a muchos inversa
    public function user(){
        return $this->belongsTo('App\Models\User');
    } 

     //Relacion muchos a muchos
     public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
