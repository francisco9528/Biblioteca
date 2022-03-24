@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-12">

            <div id="display_alert_loan">

            </div>

            <div class="card">
                <div class="card-header">Prestamo</div>

                <div class="card-body">

                    <form id="form_loans">

                        <div class="row">

                            <div class="col-md-6 form-group">
                                <label for="libro">Libro</label>
                                <select name="libro" id="libro" class="form-control form-control-sm" required>
                                </select>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control form-control-sm" min="1" required>
                            </div>

                            <div style="padding-top: 1.9rem;">
                                <button type="submit" class="btn btn-info btn-sm" id="loans">Enviar</button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@section('script')

<script>
    'use strict'; // JS en modo estricto

    // Función para traer el listado de libros
    function books() {

        $.ajax({
            url: 'list-books', // Url a la que se hara el request
            method: 'GET', // Metodo HTTP
            data: {},
            dataType: "json", // Formato de respuesta esperada
            success: function(result) {

                console.log(result.response);

                let books = result.response;

                $('#libro').empty();

                $('#libro').html(`<option value="">Seleccione una opción</option>`)

                books.forEach(objeto => {

                    $('#libro').append(`
                        <option value="${objeto.id}">${objeto.title} - ${objeto.autor} / cantidad: ${objeto.cantidad} </option>
                    `);

                });

            }
        });

    }

    $(document).ready(function() {

        // Pintamos el listado de libros en el select
        books();

        // Funcionalidad para agregar un libro
        $("#form_loans").on('submit', function(event) {

            event.preventDefault(); // Si se llama a este método, la acción predeterminada del evento no se activará.

            let formData = new FormData($(this)[0]);

            $.ajax({
                url: 'loan', // Url a la que se hara el request                    
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
                    $('#loans').prop('disabled', true);

                },
                success: function(result) {

                    // console.log(result);

                    if (result.response == 'exito') {

                        // Desencadenamos el evento reset en el formulario
                        $('#form_loans').trigger('reset');

                        books();

                        window.scrollTo(0, 0);

                        $('#display_alert_loan').html(`
                            <div class="alert alert-success">
                                <i class="far fa-check-circle"></i> <a href="#" class="alert-link"> La asignación fue realizada con exito.</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_loan').empty(), 4000);

                    } else if (result.response = 'libros insuficientes') {

                        $('#display_alert_loan').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <a href="#" class="alert-link">Libros insuficientes.</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_loan').empty(), 4000);

                    } else {

                        $('#display_alert_loan').html(`
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <a href="#" class="alert-link">Ocurrio un error al solicitar el prestamo.</a>
                            </div>
                        `);

                        setTimeout(() => $('#display_alert_loan').empty(), 4000);

                    }

                    // Desbloqueamos el button
                    $('#loans').prop('disabled', false);

                },
                error: function(jqXHR, status) {

                    // objeto jqXHR (extensión de XMLHttpRequest)
                    // console.log(jqXHR); 
                    // console.log(jqXHR.responseJSON);
                    console.log(jqXHR.responseJSON.errors);

                    let objeto_errors = jqXHR.responseJSON.errors;

                    let msg_error = null;

                    for (const property in objeto_errors) {

                        console.log(`${property}: ${objeto_errors[property]}`);

                        msg_error = objeto_errors[property]; // obtenemos siempre el primer mensaje de la validación

                        break; // termina el ciclo
                    }

                    // Desbloqueamos el button
                    $('#loans').prop('disabled', false);

                    $('#display_alert_loan').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i> <a href="#" class="alert-link">${msg_error}</a>
                        </div>
                    `);

                    setTimeout(() => $('#display_alert_loan').empty(), 4000);

                }
            });

        });

    });
</script>

@endsection