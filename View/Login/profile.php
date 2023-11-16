<?php
include_once("../../Config/config.php");
// TODO header call
new Header("Perfil", $DIRS, 3);

$session = new Session();
$objUser = $session->getUser(['idusuario']);

$usnombre = $objUser->getUsNombre();
$usmail = $objUser->getUsMail();


echo <<<HTML

<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg p-3 mb-5">
                    <div class="card-body">
                        <form action="Action/actulizarDatos.php" method="POST" id="form_control" name="form_control" class="needs-validation">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label class="mb-2">Usuario</label><br>
                                    <input id="usnombre" name="usnombre" type="text" class="form-control" maxlength="25" value="$usnombre" disabled>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label class="mb-2">Mail</label><br>
                                    <input id="usmail" name="usmail" type="text" class="form-control" maxlength="25" value="$usmail" disabled>
                                </div>
                            </div>
                    </div>
                    <button class=" btn btn-primary" type="submit" id="enviar" name="enviar">Cambiar Datos</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

HTML;
