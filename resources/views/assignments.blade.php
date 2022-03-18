@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">Asignaciones</div>

                <div class="card-body">

                    <div>

                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Titulo</th>
                                    <th>Autor</th>
                                    <th>Usuario prestamo</th>
                                    <th>Fecha prestamos</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="row_assig">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('script')

<script>
    'use strict'; // JS en modo estricto

    // Función para traer el listado de asignaciones
    function assignments() {

        $.ajax({
            url: 'assignments', // Url a la que se hara el request
            method: 'GET', // Metodo HTTP
            data: {},
            dataType: "json", // Formato de respuesta esperada
            success: function(result) {

                console.log(result.response);

                let assig = result.response;

                $('#row_assig').empty();

                assig.forEach(objeto => {

                    $('#row_assig').append(`
                                        <tr>
                                        <td>${objeto.title}</td>
                                        <td>${objeto.autor}</td>
                                        <td>${objeto.name}</td>
                                        <td>${objeto.date_output}</td>
                                        <td>1</td>
                                        </tr>
                    `);

                });

            }
        });

    }

    $(document).ready(function() {

        // Pintamos el listado de asignaciones
        assignments();

    });
</script>

@endsection