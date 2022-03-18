<?php

namespace App\Http\Controllers;

use App\Book;
use Exception;
use Illuminate\Http\Request;

class BookController extends Controller
{

    /**
     * 
     * El metodo _construct() se ejecuta cuando se instancia la clase  
     * BookController debe estar autenticado para acceder a los metodos 
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * 
     * Muestra la interfaz para libros.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInterface()
    {
        return view('books.books');
    }

    /**
     * 
     * Obtenemos el listado de los libros.
     * 
     */
    public function getBooks()
    {

        // Query para obtener los libros registrados
        $data = Book::select('id', 'title', 'autor', 'editorial', 'edition', 'cantidad', 'prestamos')->get();

        return response()->json(['response' => $data]);
    }

    /**
     * 
     * Registramos un nuevo libro.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createBook(Request $request)
    {

        // El metodo validate() retorna un array con los campos que fueron validados
        $validated_data = $request->validate([
            'title' => 'required|max:100',
            'autor' => 'required|max:100',
            'editorial' => 'required|max:100',
            'edition' => 'required|max:100',
            'cantidad' => 'required'
        ]);

        $title = $validated_data['title'];
        $autor = $validated_data['autor'];
        $editorial = $validated_data['editorial'];
        $edition = $validated_data['edition'];
        $cantidad = $validated_data['cantidad'];

        try {

            // Registramos un nuevo libro
            Book::create([
                'title' => $title,
                'autor' => $autor,
                'editorial' => $editorial,
                'edition' => $edition,
                'cantidad' => $cantidad,
                'prestamos' => 0
            ]);

            $respuesta = 'exito';
        } catch (\Exception $e) {

            $respuesta = $e->getMessage();
        }

        return response()->json(['response' => $respuesta]);
    }

    /**
     * 
     * Actualiza la información de un libro
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateBook(Request $request, $id)
    {

        // El metodo validate() retorna un array con los campos que fueron validados
        $validated_data = $request->validate([
            'title_u' => 'required|max:100',
            'autor_u' => 'required|max:100',
            'editorial_u' => 'required|max:100',
            'edition_u' => 'required|max:100',
        ]);

        $title = $validated_data['title_u'];
        $autor = $validated_data['autor_u'];
        $editorial = $validated_data['editorial_u'];
        $edition = $validated_data['edition_u'];

        try {

            Book::where('id', '=', $id)->update([
                'title' => $title,
                'autor' => $autor,
                'editorial' => $editorial,
                'edition' => $edition,
            ]);

            $respuesta = 'exito';
        } catch (\Exception $e) {

            $respuesta = $e->getMessage();
        }

        return response()->json(['response' => $respuesta]);
    }

    /**
     * Eliminamos un libro en especifico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyBook($id)
    {

        try {

            $data = Book::select('prestamos')->where('id', '=', $id)->first();

            // validamos si no existen prestamos activos
            if ($data->prestamos > 0) {

                throw new Exception('prestamos activos');
            }

            Book::where('id', '=', $id)->delete();

            $respuesta = 'exito';
        } catch (\Exception $e) {

            $respuesta = $e->getMessage();
        }

        return response()->json(['response' => $respuesta]);
    }
}
