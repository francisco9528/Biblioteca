@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div id="display_alert_return">

            </div>

            <div class="card">
                <div class="card-header">Devoluciones</div>

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
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="row_book_assig">

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
    function bookAssignments() {

        $.ajax({
            url: 'assig-books', // Url a la que se hara el request
            method: 'GET', // Metodo HTTP
            data: {},
            dataType: "json", // Formato de respuesta esperada
            success: function(result) {

                console.log(result.response);

                let assig = result.response;

                $('#row_book_assig').empty();

                assig.forEach(objeto => {

                    $('#row_book_assig').append(`
                                        <tr>
                                        <td>${objeto.title}</td>
                                        <td>${objeto.autor}</td>
                                        <td>${objeto.name}</td>
                                        <td>${objeto.date_output}</td>
                                        <td>1</td>
                                        <td><button type="button" class="btn btn-secondary btn-sm return" data-id-assig="${objeto.id}" >Devolver</button></td>
                                        </tr>
                    `);

                });

            }
        });

    }

    $(document).ready(function() {

        // Pintamos el listado de asignaciones
        bookAssignments();

        // Funcionalidad para agregar un libro
        $(document).on('click', '.return', function(event) {

            let id = $(this).data('id-assig');

            $.ajax({
                url: `return/${id}`, // Url a la que se hara el request                    
                method: 'POST', // Metodo HTTP
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'PUT'
                },
                dataType: "json", // Formato de respuesta esperada
                beforeSend: function() { // Esta función se ejecuta mientras la solicitud ajax se procesa

                    // Bloqueamos el button
                    $('.return').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        bookAssignments();

                        window.scrollTo(0, 0);

                        $('#display_alert_return').html(`
                            <div class="alert alert-success">
                                <i class="far fa-check-circle"></i> <a href="#" class="alert-link"> La devolución fue realizada con exito.</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_return').empty(), 4000);

                    } else {

                        $('#display_alert_return').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <a href="#" class="alert-link">Ocurrio un error al devolver el libro.</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_return').empty(), 4000);

                    }

                    // Desbloqueamos el button
                    $('.return').prop('disabled', false);

                },
                error: function() {

                    // Desbloqueamos el button
                    $('.return').prop('disabled', false);

                    $('#display_alert_return').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <a href="#" class="alert-link">Ocurrio un error.</a>
                            </div>
                    `);

                    setTimeout(() => $('#display_alert_return').empty(), 4000);

                }
            });

        });

    });
</script>

@endsection