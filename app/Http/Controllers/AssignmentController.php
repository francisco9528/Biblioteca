<?php

namespace App\Http\Controllers;

use App\Assignment;

class AssignmentController extends Controller
{


    /**
     * 
     * El metodo _construct() se ejecuta cuando se instancia la clase  
     * AssignmentController debe estar autenticado para acceder a los metodos 
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 
     * Muestra la interfaz para mostrar las asignaciones activas.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInterface()
    {
        return view('assignments');
    }

    /**
     * 
     * Obtenemos el listado de los libros asignados.
     * 
     */
    public function geAssignments()
    {

        // Query para obtener los libros registrados
        $data = Assignment::join('users', 'users.id', '=', 'assignments.id_user')
            ->join('books', 'books.id', '=', 'assignments.id_book')
            ->select('books.title', 'books.autor', 'users.name', 'assignments.date_output')
            ->where('flag', '=', '1') // prestamo activo
            ->get();

        return response()->json(['response' => $data]);
    }
}
