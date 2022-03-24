<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * 
     * El metodo _construct() se ejecuta cuando se instancia la clase  
     * UserController, debe estar autenticado para acceder a los metodos 
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 
     * Muestra la interfaz para el acceso a usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function showInterface()
    {
        return view('users.users');
    }

    /**
     * 
     * Obtenemos el listado de los usuarios.
     * 
     */
    public function getUsers()
    {

        // Query para obtener los usuarios registrados
        $data = User::join('status_users', 'status_users.id', '=', 'users.id_status')
            ->join('profiles', 'profiles.id', '=', 'users.id_profile')
            ->select('users.id', 'users.name', 'users.email', 'users.id_profile', 'users.id_status', 'status_users.status', 'profiles.profile')
            ->get();

        return response()->json(['response' => $data]);
    }

    /**
     * 
     * Registramos un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {

        // El metodo validate() retorna un array con los campos que fueron validados
        $validated_data = $request->validate(
            [
                'name' => 'required|max:50',
                'email' => 'required|email|max:50',
                'password' => 'required|min:8|max:16',
                'profile' => 'required'
            ]
        );

        $name = $validated_data['name'];
        $email = $validated_data['email'];
        $password = $validated_data['password'];
        $id_profile = $validated_data['profile'];

        try {

            // Validamos que el correo ingreado no este registrado
            if (User::where('email', '=', $email)->exists()) {

                throw new Exception('error email');
            }

            // Creamos un nuevo usuario
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => hash::make($password),
                'id_profile' => $id_profile,
                'id_status' => 1,
            ]);

            $respuesta = 'exito';
        } catch (\Exception $e) {

            $respuesta = $e->getMessage();
        }

        return response()->json(['response' => $respuesta]);
    }

    /**
     * 
     * Actualiza la información del usuario registrado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUser(Request $request, $id)
    {

        $password = $request->input('password_u');

        if (empty($password)) {

            // Validamos los datos enviados en el request
            $validated_data = $request->validate(
                [
                    'name_u' => 'required|max:50',
                    'email_u' => 'required|email|max:50',
                    'profile_u' => 'required',
                    'stat_u' => 'required'
                ]
            );
        } else {

            // Validamos los datos enviados en el request
            $validated_data = $request->validate(
                [
                    'name_u' => 'required|max:50',
                    'email_u' => 'required|email|max:50',
                    'password_u' => 'required|min:8|max:16',
                    'profile_u' => 'required',
                    'stat_u' => 'required'
                ]
            );

            $edited_password = $validated_data['password_u'];
        }

        // Datos
        $name = $validated_data['name_u'];
        $email = $validated_data['email_u'];
        $id_profile = $validated_data['profile_u'];
        $id_status = $validated_data['stat_u'];

        try {

            /*
            * Verificamos que el correo del request no este registrado
            * O verificamos que sea el mismo que este registrado para el usuario
            */

            if (!User::where('id', '!=', $id)->where('email', '=', $email)->exists() || User::where('id', '=', $id)->where('email', '=', $email)->exists()) {

                if (empty($password)) {

                    User::where('id', '=', $id)->update([
                        'name' => $name,
                        'email' => $email,
                        'id_profile' => $id_profile,
                        'id_status' => $id_status
                    ]);
                } else {

                    User::where('id', '=', $id)->update([
                        'name' => $name,
                        'email' => $email,
                        'password' => Hash::make($edited_password),
                        'id_profile' => $id_profile,
                        'id_status' => $id_status
                    ]);
                }
            } else {

                throw new Exception('error email');
            }

            $respuesta = 'exito';
        } catch (\Exception $e) {

            $respuesta = $e->getMessage();
        }

        return response()->json(['response' => $respuesta]);
    }
}
