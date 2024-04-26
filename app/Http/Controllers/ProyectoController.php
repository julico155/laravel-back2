<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
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

    public function exportarjava($codigo){
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Obtener los atributos del proyecto
        $nombreProyecto = $proyecto->nombre;
        $contenidoProyecto = $proyecto->content;
    
        // Parsear el contenido XML del proyecto
        $xml = simplexml_load_string($contenidoProyecto);
        $cells = $xml->xpath("//mxCell");
    
        // Generar el código Java representando la clase, objetos e instancias de método
        $javaCode = "// Java code representing the class, object instances, and method instances\n";
        $javaCode .= "public class $nombreProyecto {\n";
    
        foreach ($cells as $cell) {
            $id = (string) $cell['id'];
            $value = (string) $cell['value'];
            $style = (string) $cell['style'];
            $geometry = $cell->mxGeometry->attributes();
    
            // Crear instancias de objetos basados en las lifelines
            if (strpos($style, 'umlLifeline') !== false) {
                $javaCode .= "\n\t// Object instance for lifeline $id: $value\n";
                $javaCode .= "\tprivate $value $value$id = new $value();\n";
                $javaCode .= "\t// Geometry: x=" . $geometry['x'] . ", y=" . $geometry['y'] . ", width=" . $geometry['width'] . ", height=" . $geometry['height'] . "\n";
            }
    
            // Crear instancias de métodos basados en las flechas (edges)
            if (strpos($style, 'edge') !== false) {
                $source = (string) $cell->mxGeometry->mxPoint[0]->attributes()->{'x'};
                $target = (string) $cell->mxGeometry->mxPoint[1]->attributes()->{'x'};
                $methodName = "method$id"; // Nombre del método basado en el ID
                $method = "void $methodName() {\n\t// Logic for arrow from $source to $target\n}\n";
                $javaCode .= "\n\t// Method instance for arrow $id\n$method";
            }
        }
    
        $javaCode .= "}\n";
    
        // Devolver el código Java generado
        return $javaCode;
    }

    public function exportarphp($codigo){
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Obtener los atributos del proyecto
        $nombreProyecto = $proyecto->nombre;
        $contenidoProyecto = $proyecto->content;
    
        // Parsear el contenido XML del proyecto
        $xml = simplexml_load_string($contenidoProyecto);
        $cells = $xml->xpath("//mxCell");
    
        // Generar el código PHP representando la clase, objetos e instancias de método
        $phpCode = "// PHP code representing the class, object instances, and method instances\n";
        $phpCode .= "class $nombreProyecto {\n";
    
        foreach ($cells as $cell) {
            $id = (string) $cell['id'];
            $value = (string) $cell['value'];
            $style = (string) $cell['style'];
            $geometry = $cell->mxGeometry->attributes();
    
            // Crear instancias de objetos basados en las lifelines
            if (strpos($style, 'umlLifeline') !== false) {
                $phpCode .= "\n\t// Object instance for lifeline $id: $value\n";
                $phpCode .= "\tprivate \$$value$id;\n";
                $phpCode .= "\t// Geometry: x=" . $geometry['x'] . ", y=" . $geometry['y'] . ", width=" . $geometry['width'] . ", height=" . $geometry['height'] . "\n";
            }
    
            // Crear instancias de métodos basados en las flechas (edges)
            if (strpos($style, 'edge') !== false) {
                $source = (string) $cell->mxGeometry->mxPoint[0]->attributes()->{'x'};
                $target = (string) $cell->mxGeometry->mxPoint[1]->attributes()->{'x'};
                $methodName = "method$id"; // Nombre del método basado en el ID
                $phpCode .= "\n\t// Method instance for arrow $id\n";
                $phpCode .= "\tpublic function $methodName() {\n\t\t// Logic for arrow from $source to $target\n\t}\n";
            }
        }
    
        $phpCode .= "}\n";
    
        // Devolver el código PHP generado
        return $phpCode;
    }
    public function exportarpython($codigo){
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Obtener los atributos del proyecto
        $nombreProyecto = $proyecto->nombre;
        $contenidoProyecto = $proyecto->content;
    
        // Parsear el contenido XML del proyecto
        $xml = simplexml_load_string($contenidoProyecto);
        $cells = $xml->xpath("//mxCell");
    
        // Generar el código Python representando la clase, objetos e instancias de método
        $pythonCode = "# Python code representing the class, object instances, and method instances\n";
        $pythonCode .= "class $nombreProyecto:\n";
    
        foreach ($cells as $cell) {
            $id = (string) $cell['id'];
            $value = (string) $cell['value'];
            $style = (string) $cell['style'];
            $geometry = $cell->mxGeometry->attributes();
    
            // Crear instancias de objetos basados en las lifelines
            if (strpos($style, 'umlLifeline') !== false) {
                $pythonCode .= "\n\t# Object instance for lifeline $id: $value\n";
                $pythonCode .= "\tdef __init__(self):\n";
                $pythonCode .= "\t\tself.$value$id = None\n";
                $pythonCode .= "\t\t# Geometry: x=" . $geometry['x'] . ", y=" . $geometry['y'] . ", width=" . $geometry['width'] . ", height=" . $geometry['height'] . "\n";
            }
    
            // Crear instancias de métodos basados en las flechas (edges)
            if (strpos($style, 'edge') !== false) {
                $source = (string) $cell->mxGeometry->mxPoint[0]->attributes()->{'x'};
                $target = (string) $cell->mxGeometry->mxPoint[1]->attributes()->{'x'};
                $methodName = "method$id"; // Nombre del método basado en el ID
                $pythonCode .= "\n\t# Method instance for arrow $id\n";
                $pythonCode .= "\tdef $methodName(self):\n";
                $pythonCode .= "\t\t# Logic for arrow from $source to $target\n";
            }
        }
    
        // Devolver el código Python generado
        return $pythonCode;
    }
    

    
    public function descargarCodigoPhp($codigo) {
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Generar el código Java
        $codigoJava = $this->exportarjava($codigo);
    
        // Devolver la respuesta de descarga
        return response($codigoJava)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=codigo_php.php');
    }

    public function descargarCodigoPython($codigo) {
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Generar el código Java
        $codigoJava = $this->exportarpython($codigo);
    
        // Devolver la respuesta de descarga
        return response($codigoJava)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=codigo_python.py');
    }
    
    
    

    
    public function descargarCodigoJava($codigo) {
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Generar el código Java
        $codigoJava = $this->exportarjava($codigo);
    
        // Devolver la respuesta de descarga
        return response($codigoJava)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename=codigo_java.java');
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
