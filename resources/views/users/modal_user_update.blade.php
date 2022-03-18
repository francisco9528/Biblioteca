<div id="modal_user_update" class="modal fade">

    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Acceso usuario</h4>
                <button type="button" class="close close_user_update">&times;</button>
            </div>

            <form id="form_user_update">

                <input type="hidden" name="user_u" id="user_u">

                <div class="modal-body">

                    <div id="display_alert_updte">

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="name_u">Nombre</label>
                            <input type="text" id="name_u" name="name_u" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="email_u">Email</label>
                            <input type="email" id="email_u" name="email_u" class="form-control form-control-sm" maxlength="50" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">

                            <label for="password_u">Password</label>
                            <input type="password" id="password_u" name="password_u" class="form-control form-control-sm" maxlength="16">

                            <p class="small mb-0">Intervalo de contraseña valido [8-16].</p>
                            <p class="small mb-0">La contraseña debe contener como minimo un numero, una letra mayuscula, una letra minuscula y un simbolo.</p>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="profile_u">Perfil</label>
                            <select id="profile_u" name="profile_u" class="form-control form-control-sm" required>
                                <option value="">Seleccione una opción</option>
                                <option value="1">Administrador</option>
                                <option value="2">Prestatario</option>
                            </select>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12 form-group">
                            <label for="stat_u">Estatus</label>
                            <select id="stat_u" name="stat_u" class="form-control form-control-sm" required>
                                <option value="">Seleccione una opción</option>
                                <option value="1">Activo</option>
                                <option value="2">Baja</option>
                            </select>
                        </div>

                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="update_user" class="btn btn-success">Enviar</button>
                    <button type="button" class="btn btn-danger close_user_update">Cerrar</button>
                </div>

            </form>

        </div>

    </div>
</div>