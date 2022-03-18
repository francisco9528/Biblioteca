<div id="modal_book_add" class="modal fade">

    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Libros</h4>
                <button type="button" class="close close_book_add">&times;</button>
            </div>

            <form id="form_book_add">

                <div class="modal-body">

                    <div id="display_alert_add">

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="title">Titulo</label>
                            <input type="text" id="title" name="title" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="autor">Autor</label>
                            <input type="text" id="autor" name="autor" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="editorial">Editorial</label>
                            <input type="text" id="editorial" name="editorial" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="edition">Edición</label>
                            <input type="text" id="edition" name="edition" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control form-control-sm" min="1" required>
                        </div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="add_book" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger close_book_add">Cerrar</button>
                </div>

            </form>

        </div>

    </div>
</div>