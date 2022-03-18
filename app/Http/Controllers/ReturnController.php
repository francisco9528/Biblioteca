<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Book;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * 
     * El metodo _construct() se ejecuta cuando se instancia la clase  
     * ReturnController debe estar autenticado para acceder a los metodos 
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 
     * Muestra la interfaz para los prestamos.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInterface()
    {
        return view('returns');
    }

    /**
     * 
     * Obtenemos el listado de los libros asignados por usuario.
     * 
     */
    public function getListAssignmentsUser()
    {

        // Query para obtener los libros registrados
        $data = Assignment::join('users', 'users.id', '=', 'assignments.id_user')
            ->join('books', 'books.id', '=', 'assignments.id_book')
            ->select('assignments.id', 'books.title', 'books.autor', 'users.name', 'assignments.date_output')
            ->where('assignments.id_user', '=', auth()->id())
            ->where('flag', '=', '1') // prestamo activo
            ->get();


        return  response()->json(['response' => $data]);
    }

    /**
     * 
     * Retornar libro prestado.
     * 
     */
    public function updateReturnBook($id)
    {

        try {

            DB::beginTransaction();

            Assignment::where('id', '=', $id)->update([
                'date_input' => date('Y-m-d H:i:s'),
                'flag' => 0, // devolucion activa
            ]);

            $assig = Assignment::select('id_book')->where('id', '=', $id)->first();

            $book = Book::select('id', 'cantidad', 'prestamos')->where('id', '=', $assig->id_book)->first();

            Book::where('id', '=', $book->id)->update([
                'cantidad' => ($book->cantidad + 1),
                'prestamos' => ($book->prestamos - 1),
            ]);

            DB::commit();

            $respuesta = 'exito';
        } catch (\Exception $e) {

            DB::rollback();

            $respuesta = $e->getMessage();
        }

        return response()->json(['response' => $respuesta]);
    }
}
