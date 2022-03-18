<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
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
     * Muestra la interfaz para los prestamos.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInterface()
    {
        return view('loans');
    }

    /**
     * 
     * Obtenemos el listado de los libros.
     * 
     */
    public function getBooks()
    {

        // Query para obtener los libros registrados
        $data = Book::select('id', 'title', 'autor', 'editorial', 'edition', 'cantidad')->get();

        return response()->json(['response' => $data]);
    }

    /**
     * 
     * Registramos prestamos libro.
     * 
     */
    public function createLoansBook(Request $request)
    {

        // El metodo validate() retorna un array con los campos que fueron validados
        $validated_data = $request->validate([
            'libro' => 'required',
            'cantidad' => 'required',
        ]);

        $id_book = $validated_data['libro'];
        $number = $validated_data['cantidad'];

        try {

            DB::beginTransaction();

            $book = Book::select('cantidad', 'prestamos')->where('id', '=', $id_book)->first();

            if ($book->cantidad < $number) {

                throw new Exception('libros insuficientes');
            }

            for ($i = 0; $i < $number; $i++) {

                Assignment::create([
                    'id_user' => auth()->id(),
                    'id_book' => $id_book,
                    'date_output' => date('Y-m-d H:i:s'),
                    'flag' => 1, // devolucion activa
                ]);
            }

            Book::where('id', '=', $id_book)->update([
                'cantidad' => $book->cantidad - $number,
                'prestamos' => $book->prestamos + $number,
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
