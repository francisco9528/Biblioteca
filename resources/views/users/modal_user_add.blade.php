<div id="modal_user_add" class="modal fade">

    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Acceso usuario</h4>
                <button type="button" class="close close_user_add">&times;</button>
            </div>

            <form id="form_user_add">

                <div class="modal-body">


                    <div id="display_alert_add">

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">

                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control form-control-sm" maxlength="16" required>

                            <p class="small mb-0">Intervalo de contraseña valido [8-16].</p>
                            <p class="small mb-0">La contraseña debe contener como minimo un numero, una letra mayuscula, una letra minuscula y un simbolo.</p>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="profile">Perfil</label>
                            <select id="profile" name="profile" class="form-control form-control-sm" required>
                                <option value="">Seleccione una opción</option>
                                <option value="1">Administrador</option>
                                <option value="2">Prestatario</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="add_user" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger close_user_add">Cerrar</button>
                </div>

            </form>

        </div>

    </div>
</div>