<div id="modal_book_update" class="modal fade">

    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Libros</h4>
                <button type="button" class="close close_book_update">&times;</button>
            </div>

            <form id="form_book_update">

                <input type="hidden" name="book_u" id="book_u">

                <div class="modal-body">

                    <div id="display_alert_updte">

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="title_u">Titulo</label>
                            <input type="text" id="title_u" name="title_u" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="autor_u">Autor</label>
                            <input type="text" id="autor_u" name="autor_u" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="editorial_u">Editorial</label>
                            <input type="text" id="editorial_u" name="editorial_u" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="edition_u">Edición</label>
                            <input type="text" id="edition_u" name="edition_u" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="cantidad_u">Cantidad</label>
                            <input type="text" id="cantidad_u" name="cantidad_u" class="form-control form-control-sm" readonly>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="prestamos_u">Prestamos</label>
                            <input type="number" id="prestamos_u" name="prestamos_u" class="form-control form-control-sm" readonly>
                        </div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="update_book" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger close_book_update">Cerrar</button>
                </div>

            </form>

        </div>

    </div>
</div>