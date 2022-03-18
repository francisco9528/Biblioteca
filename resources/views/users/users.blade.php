@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">

        <div class="col-md-12">

            <div class="card">
                <div class="card-header">Agregar usuarios</div>

                <div class="card-body">

                    <div>
                        <button type="button" id="add_user" class="btn btn-info mb-4">
                            Agregar
                        </button>

                        <table class="table table-bordered table-hover table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Perfil</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="row_user">

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

</div>

<!-- modal user -->
@include('users.modal_user_add')
@include('users.modal_user_update')

@endsection

@section('script')

<script>
    'use strict'; // JS en modo estricto

    // Función para traer el listado de usuarios
    function users() {

        $.ajax({
            url: '/users', // Url a la que se hara el request
            method: 'GET', // Metodo HTTP
            data: {},
            dataType: "json", // Formato de respuesta esperada
            success: function(result) {

                // console.log(result.response);

                let users = result.response;

                $('#row_user').empty();

                users.forEach(objeto => {

                    $('#row_user').append(`
                                        <tr>
                                        <td>${objeto.name}</td>
                                        <td>${objeto.email}</td>
                                        <td>${objeto.profile}</td>
                                        <td>${objeto.status}</td>
                                        <td><button type="button" class="btn btn-secondary btn-sm update_user" data-id-user="${objeto.id}" data-name="${objeto.name}" data-email="${objeto.email}" data-id-profile="${objeto.id_profile}" data-id-status="${objeto.id_status}">Actualizar</button></td>
                                        </tr>
                    `);

                });

            }
        });

    }

    $(document).ready(function() {

        // Pintamos el listado de usuarios
        users();

        // Logica para abrir el modal para agregar un usuario
        $('#add_user').on('click', function() {

            // Abrir modal con un fondo estatico
            $('#modal_user_add').modal({
                backdrop: 'static'
            })

        });

        // Logica para abrir el modal para actualizar usuarios
        $(document).on('click', '.update_user', function() {

            let id_user = $(this).data('id-user');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let id_status = $(this).data('id-status');
            let id_profile = $(this).data('id-profile');

            $('#user_u').val(id_user);
            $('#name_u').val(name);
            $('#email_u').val(email);
            $('#profile_u').val(id_profile);
            $('#stat_u').val(id_status);

            // Abrir modal con un fondo estatico
            $('#modal_user_update').modal({
                backdrop: 'static'
            })

        });

        // Logica para cerra el modal
        $("#modal_user_add").on('click', '.close_user_add', function() {

            // Desencadenamos el evento reset en el formulario
            $('#form_user_add').trigger('reset');

            // Cierra el modal
            $("#modal_user_add").modal("hide");

        });

        // Logica para cerra el modal
        $("#modal_user_update").on('click', '.close_user_update', function() {

            // Desencadenamos el evento reset en el formulario
            $('#form_user_update').trigger('reset');

            // Cierra el modal
            $("#modal_user_update").modal("hide");

        });

        // Funcionalidad para agregar un usuario
        $("#form_user_add").on('submit', function(event) {

            event.preventDefault(); // Si se llama a este método, la acción predeterminada del evento no se activará.

            let formData = new FormData($(this)[0]);

            $.ajax({
                url: 'user', // Url a la que se hara el request                    
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
                    $('#add_user').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        // Desencadenamos el evento reset en el formulario
                        $('#form_user_add').trigger('reset');

                        // Cierra el modal
                        $("#modal_user_add").modal("hide");

                        users();

                    } else if (result.response == 'error email') {

                        $('#display_alert_add').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia! </strong> <a href="#" class="alert-link">Correo electrónico ingresado ya esta registrado</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_add').empty(), 10000);

                    } else {

                        $('#display_alert_add').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia! </strong> <a href="#" class="alert-link">Ocurrio un error al agregar un usuario</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_add').empty(), 10000);

                    }

                    // Desbloqueamos el button
                    $('#add_user').prop('disabled', false);

                },
                error: function(jqXHR) {

                    // Desbloqueamos el button
                    $('#add_user').prop('disabled', false);

                    $('#display_alert_add').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia! </strong> <a href="#" class="alert-link">Los parametros ingresados son incorrectos</a>
                            </div>
                        `);

                    setTimeout(() => $('#display_alert_add').empty(), 10000);

                }
            });

        });

        // Funcionalidad para editar un usuario
        $("#form_user_update").on('submit', function(event) {

            // Si se llama a este método, la acción predeterminada del evento no se activará.
            event.preventDefault();

            let id = $('#user_u').val();

            // Utilizamos la clase FormData y compilamos los valores ingresados en el formulario
            let formData = new FormData($(this)[0]);

            // Especificamos el metodo PUT para el request
            formData.append('_method', 'PUT');

            $.ajax({
                url: `user/${id}`, // Url a la que se hara el request
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
                    $('#update_user').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        // Desencadenamos el evento reset en el formulario
                        $('#form_user_update').trigger('reset');

                        // Cierra el modal
                        $("#modal_user_update").modal("hide");

                        users();

                    } else if (result.response == 'error email') {

                        $('#display_alert_update').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong> <a href="#" class="alert-link">Correo electrónico ingresado ya esta registrado</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_update').empty(), 10000);

                    } else {

                        $('#display_alert_update').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong> <a href="#" class="alert-link">Ocurrio un error al actualizar el usuario</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_update').empty(), 10000);

                    }

                    // Desbloqueamos el button
                    $('#update_user').prop('disabled', false);

                },
                error: function() {

                    // Desbloqueamos el button
                    $('#update_user').prop('disabled', false);

                    $('#display_alert_update').html(`
                            <div class="alert alert-danger">
                                 <strong>Advertencia!</strong> <a href="#" class="alert-link">Los parametros ingresados son incorrectos</a>
                            </div>
                        `);

                    setTimeout(() => $('#display_alert_update').empty(), 10000);

                }
            });

        });

    });
</script>

@endsection