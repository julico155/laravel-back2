<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Http\Request;
use DOMDocument;

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

    public function exportarjava($codigo) {
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Obtener los atributos del proyecto
        $nombreProyecto = $proyecto->nombre;
        $contenidoProyecto = $proyecto->content;
    
        // Verificar si el contenido XML es válido
        if (!$this->isXMLContentValid($contenidoProyecto)) {
            // Manejar el caso de contenido XML no válido
            // Puedes mostrar un mensaje de error o tomar otra acción
            return "Error: El contenido XML no es válido.";
        }
    
        // Parsear el contenido XML del proyecto
        $xml = simplexml_load_string($contenidoProyecto);
        $cells = $xml->xpath("//mxCell");
    
        // Generar el código Java representando la clase, objetos e instancias de método
        $javaCode = "// Java code representing the class, object instances, and method instances\n";
        $javaCode .= "public class $nombreProyecto {\n";
    
        foreach ($cells as $cell) {
            $style = (string)$cell->attributes()->style;
            $value = (string)$cell->attributes()->value;
    
            // Verificar si el nodo es un umlFrame
            if (strpos($style, "shape=umlFrame") !== false) {
                // Generar el método void con el nombre igual al valor del nodo umlFrame
                $javaCode .= "    void $value(String x) {\n";
    
                // Generar el bloque if-else para cada opción dentro del umlFrame
                $javaCode .= "        if (x.equals(\"$value\")) {\n";
                $javaCode .= "            // Código para la opción $value\n";
                $javaCode .= "        } else {\n";
                $javaCode .= "            // Código para las demás opciones\n";
                $javaCode .= "        }\n";
    
                // Cerrar el método void
                $javaCode .= "    }\n";
            } else if (strpos($style, "endArrow=block") !== false) {
                // Si el estilo incluye "endArrow=block", trata este nodo como una flecha de mensaje
                // Generar un método void con el nombre igual al valor del nodo
                $javaCode .= "    void $value() {\n    }\n";
            } else if (strpos($style, "umlLifeline") !== false) {
                // Si el estilo incluye "umlLifeline", trata este nodo como una clase
                $javaCode .= "    class $value {\n";
            } else if (strpos($style, "umlActor") !== false) {
                // Si el estilo incluye "umlActor", trata este nodo como una clase
                $javaCode .= "    class $value {\n";
            } else {
                // Otros nodos o estilos pueden manejarse aquí según sea necesario
                // Por ahora, solo los ignoraremos
                continue;
            }
    
            // Cierre de la declaración de clase o función
            $javaCode .= "    }\n";
        }
    
        $javaCode .= "}\n";
    
        // Devolver el código Java generado
        return $javaCode;
    }
      
    
    // Función para validar el contenido XML
    public function isXMLContentValid($xmlContent) {
        if (trim($xmlContent) == '') {
            return false;
        }
    
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $doc->loadXML($xmlContent);
        $errors = libxml_get_errors();
        libxml_clear_errors();
    
        return empty($errors);
    }
    

    public function exportarphp($codigo) {
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Obtener los atributos del proyecto
        $nombreProyecto = $proyecto->nombre;
        $contenidoProyecto = $proyecto->content;
    
        // Verificar si el contenido XML es válido
        if (!$this->isXMLContentValid($contenidoProyecto)) {
            // Manejar el caso de contenido XML no válido
            // Puedes mostrar un mensaje de error o tomar otra acción
            return "Error: El contenido XML no es válido.";
        }
    
        // Parsear el contenido XML del proyecto
        $xml = simplexml_load_string($contenidoProyecto);
        $cells = $xml->xpath("//mxCell");
    
        // Generar el código PHP representando la clase, objetos e instancias de método
        $phpCode = "// PHP code representing the class, object instances, and method instances\n";
        $phpCode .= "class $nombreProyecto {\n";
    
        foreach ($cells as $cell) {
            $style = (string) $cell->attributes()->style;
            $value = (string) $cell->attributes()->value;
    
            // Verificar si el nodo es un umlFrame
            if (strpos($style, "shape=umlFrame") !== false) {
                // Generar el método void con el nombre igual al valor del nodo umlFrame
                $phpCode .= "\n\t// Método void representando el umlFrame $value\n";
                $phpCode .= "\tpublic function $value(\$x) {\n";
                $phpCode .= "\t\t// Lógica para el umlFrame $value\n";
                $phpCode .= "\t\tif (\$x == '$value') {\n";
                $phpCode .= "\t\t\t// Código para la opción $value\n";
                $phpCode .= "\t\t} else {\n";
                $phpCode .= "\t\t\t// Código para las demás opciones\n";
                $phpCode .= "\t\t}\n";
                $phpCode .= "\t}\n";
            } else if (strpos($style, "endArrow=block") !== false) {
                // Si el estilo incluye "endArrow=block", trata este nodo como una flecha de mensaje
                // Generar un método void con el nombre igual al valor del nodo
                $phpCode .= "\n\t// Método void representando una flecha de mensaje $value\n";
                $phpCode .= "\tpublic function $value() {\n";
                $phpCode .= "\t\t// Lógica para la flecha de mensaje $value\n";
                $phpCode .= "\t}\n";
            } else if (strpos($style, "umlLifeline") !== false) {
                // Si el estilo incluye "umlLifeline", trata este nodo como una clase
                $phpCode .= "\n\t// Clase representando la lifeline $value\n";
                $phpCode .= "\tclass $value {\n";
                $phpCode .= "\t\t// Propiedades y métodos de la clase $value\n";
                $phpCode .= "\t}\n";
            } else if (strpos($style, "umlActor") !== false) {
                // Si el estilo incluye "umlActor", trata este nodo como una clase
                $phpCode .= "\n\t// Clase representando el actor $value\n";
                $phpCode .= "\tclass $value {\n";
                $phpCode .= "\t\t// Propiedades y métodos de la clase $value\n";
                $phpCode .= "\t}\n";
            } else {
                // Otros nodos o estilos pueden manejarse aquí según sea necesario
                // Por ahora, solo los ignoraremos
                continue;
            }
        }
    
        $phpCode .= "}\n";
    
        // Devolver el código PHP generado
        return $phpCode;
    }
    
    public function exportarpython($codigo) {
        // Obtener el proyecto
        $proyecto = Proyecto::where('codigo', $codigo)->first();
    
        // Obtener los atributos del proyecto
        $nombreProyecto = $proyecto->nombre;
        $contenidoProyecto = $proyecto->content;
    
        // Verificar si el contenido XML es válido
        if (!$this->isXMLContentValid($contenidoProyecto)) {
            // Manejar el caso de contenido XML no válido
            // Puedes mostrar un mensaje de error o tomar otra acción
            return "Error: El contenido XML no es válido.";
        }
    
        // Parsear el contenido XML del proyecto
        $xml = simplexml_load_string($contenidoProyecto);
        $cells = $xml->xpath("//mxCell");
    
        // Generar el código Python representando la clase, objetos e instancias de método
        $pythonCode = "# Python code representing the class, object instances, and method instances\n";
        $pythonCode .= "class $nombreProyecto:\n";
    
        foreach ($cells as $cell) {
            $style = (string) $cell->attributes()->style;
            $value = (string) $cell->attributes()->value;
    
            // Verificar si el nodo es un umlFrame
            if (strpos($style, "shape=umlFrame") !== false) {
                // Generar la función con el nombre igual al valor del nodo umlFrame
                $pythonCode .= "    def $value(self, x):\n";
                $pythonCode .= "        # Bloque if-else para cada opción dentro del umlFrame\n";
                $pythonCode .= "        if x == \"$value\":\n";
                $pythonCode .= "            # Código para la opción $value\n";
                $pythonCode .= "        else:\n";
                $pythonCode .= "            # Código para las demás opciones\n";
            } else if (strpos($style, "endArrow=block") !== false) {
                // Si el estilo incluye "endArrow=block", trata este nodo como una flecha de mensaje
                // Generar una función con el nombre igual al valor del nodo
                $pythonCode .= "    def $value(self):\n";
                $pythonCode .= "        pass\n"; // No hay lógica específica en este caso
            } else if (strpos($style, "umlLifeline") !== false) {
                // Si el estilo incluye "umlLifeline", trata este nodo como una clase
                $pythonCode .= "    class $value:\n";
            } else if (strpos($style, "umlActor") !== false) {
                // Si el estilo incluye "umlActor", trata este nodo como una clase
                $pythonCode .= "    class $value:\n";
            } else {
                // Otros nodos o estilos pueden manejarse aquí según sea necesario
                // Por ahora, solo los ignoraremos
                continue;
            }
    
            // Cierre de la declaración de clase o función
            $pythonCode .= "\n";
    
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
