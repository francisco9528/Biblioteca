@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">Libros</div>

                <div class="card-body">

                    <div>
                        <button type="button" id="add_book" class="btn btn-info mb-4">
                            Agregar
                        </button>

                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>titulo</th>
                                    <th>Autor</th>
                                    <th>Editorial</th>
                                    <th>Edición</th>
                                    <th>Cantidad</th>
                                    <th>Prestamos</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="row_book">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div id="display_alert_delete">

            </div>

        </div>

    </div>

</div>

<!-- modal book -->
@include('books.modal_book_add')
@include('books.modal_book_update')

@endsection


@section('script')

<script>
    'use strict'; // JS en modo estricto

    // Función para traer el listado de libros
    function books() {

        $.ajax({
            url: 'books', // Url a la que se hara el request
            method: 'GET', // Metodo HTTP
            data: {},
            dataType: "json", // Formato de respuesta esperada
            success: function(result) {

                console.log(result.response);

                let books = result.response;

                $('#row_book').empty();

                books.forEach(objeto => {

                    $('#row_book').append(`
                                        <tr>
                                        <td>${objeto.title}</td>
                                        <td>${objeto.autor}</td>
                                        <td>${objeto.editorial}</td>
                                        <td>${objeto.edition}</td>
                                        <td>${objeto.cantidad}</td>
                                        <td>${objeto.prestamos}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-secondary btn-sm update_book" data-id-book="${objeto.id}" data-title="${objeto.title}" data-autor="${objeto.autor}" data-editorial="${objeto.editorial}" data-edition="${objeto.edition}" data-cantidad="${objeto.cantidad}" data-prestamos="${objeto.prestamos}">Actualizar</button>
                                            <button type="button" class="btn btn-danger btn-sm delete_book" data-id-book="${objeto.id}">Eliminar</button>
                                        </td>
                                        </tr>
                    `);

                });

            }
        });

    }

    $(document).ready(function() {

        // Pintamos el listado de libros
        books();

        // Logica para abrir el modal para agregar un libro
        $('#add_book').on('click', function() {

            // Abrir modal con un fondo estatico
            $('#modal_book_add').modal({
                backdrop: 'static'
            })

        });

        // Logica para abrir el modal para actualizar libro
        $(document).on('click', '.update_book', function() {

            let id_book = $(this).data('id-book');
            let title = $(this).data('title');
            let autor = $(this).data('autor');
            let editorial = $(this).data('editorial');
            let edition = $(this).data('edition');
            let cantidad = $(this).data('cantidad');
            let prestamos = $(this).data('prestamos');

            $('#book_u').val(id_book);
            $('#title_u').val(title);
            $('#autor_u').val(autor);
            $('#editorial_u').val(editorial);
            $('#edition_u').val(edition);
            $('#cantidad_u').val(cantidad);
            $('#prestamos_u').val(prestamos);

            // Abrir modal con un fondo estatico
            $('#modal_book_update').modal({
                backdrop: 'static'
            })

        });

        // Logica para cerra el modal
        $("#modal_book_add").on('click', '.close_book_add', function() {

            // Desencadenamos el evento reset en el formulario
            $('#form_book_add').trigger('reset');

            // Cierra el modal
            $("#modal_book_add").modal("hide");

        });

        // Logica para cerra el modal
        $("#modal_book_update").on('click', '.close_book_update', function() {

            // Desencadenamos el evento reset en el formulario
            $('#form_book_update').trigger('reset');

            // Cierra el modal
            $("#modal_book_update").modal("hide");

        });

        // Funcionalidad para agregar un libro
        $("#form_book_add").on('submit', function(event) {

            event.preventDefault(); // Si se llama a este método, la acción predeterminada del evento no se activará.

            let formData = new FormData($(this)[0]);

            $.ajax({
                url: 'book', // Url a la que se hara el request                    
                method: 'POST', // Metodo HTTP
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: "json", // Formato de respuesta esperada
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() { // Esta función se ejecuta mientras la solicitud ajax se procesa

                    // Bloqueamos el button
                    $('#add_book').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        // Desencadenamos el evento reset en el formulario
                        $('#form_book_add').trigger('reset');

                        // Cierra el modal
                        $("#modal_book_add").modal("hide");

                        books();

                    } else {

                        $('#display_alert_add').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong> You should <a href="#" class="alert-link">Ocurrio un error al agregar el libro</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_add').empty(), 10000);

                    }

                    // Desbloqueamos el button
                    $('#add_book').prop('disabled', false);

                },
                error: function(jqXHR) {

                    // Desbloqueamos el button
                    $('#add_book').prop('disabled', false);

                    $('#display_alert_add').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong> You should <a href="#" class="alert-link">Los parametros ingresados son incorrectos</a>
                            </div>
                    `);

                    setTimeout(() => $('#display_alert_add').empty(), 10000);

                }
            });

        });

        // Funcionalidad para editar un libro
        $("#form_book_update").on('submit', function(event) {

            // Si se llama a este método, la acción predeterminada del evento no se activará.
            event.preventDefault();

            let id = $('#book_u').val();

            // Utilizamos la clase FormData y compilamos los valores ingresados en el formulario
            let formData = new FormData($(this)[0]);

            // Especificamos el metodo PUT para el request
            formData.append('_method', 'PUT');

            $.ajax({
                url: `book/${id}`, // Url a la que se hara el request
                method: 'POST', // Metodo HTTP
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: "json", // Formato de respuesta esperada
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() { // Esta función se ejecuta mientras la solicitud ajax se procesa

                    // Bloqueamos el button
                    $('#update_book').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        // Desencadenamos el evento reset en el formulario
                        $('#form_book_update').trigger('reset');

                        // Cierra el modal
                        $("#modal_book_update").modal("hide");

                        books();

                    } else {

                        $('#display_alert_update').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong><a href="#" class="alert-link">Ocurrio un error al agregar el libro</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_update').empty(), 10000);

                    }

                    // Desbloqueamos el button
                    $('#update_book').prop('disabled', false);

                },
                error: function(jqXHR) {

                    // Desbloqueamos el button
                    $('#update_book').prop('disabled', false);

                    $('#display_alert_update').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong><a href="#" class="alert-link">Los parametros ingresados son incorrectos</a>
                            </div>
                    `);

                    setTimeout(() => $('#display_alert_update').empty(), 10000);

                }
            });

        });

        // Funcionalidad para eliminar un libro
        $(document).on('click', '.delete_book', function(event) {

            let id = $(this).data('id-book');

            $.ajax({
                url: `book/${id}`, // Url a la que se hara el request
                method: 'POST', // Metodo HTTP
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    '_method': 'DELETE'
                },
                dataType: "json", // Formato de respuesta esperada
                beforeSend: function() { // Esta función se ejecuta mientras la solicitud ajax se procesa

                    // Bloqueamos el button
                    $('.delete_book').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        books();

                    } else if (result.response == 'prestamos activos') {

                        $('#display_alert_delete').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong><a href="#" class="alert-link">Existen prestamos activos</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_delete').empty(), 10000);

                    } else {

                        $('#display_alert_delete').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong><a href="#" class="alert-link">Ocurrio un error al eliminar el libro</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_delete').empty(), 10000);

                    }

                    // Desbloqueamos el button
                    $('.delete_book').prop('disabled', false);

                },
                error: function() {

                    // Desbloqueamos el button
                    $('.delete_book').prop('disabled', false);

                    $('#display_alert_delete').html(`
                        <div class="alert alert-danger">
                            <strong>Advertencia!</strong><a href="#" class="alert-link">Ocurrio un error</a>
                        </div>
                    `);

                    setTimeout(() => $('#display_alert_delete').empty(), 10000);

                }
            });

        });


    });
</script>

@endsection