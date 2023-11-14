<?php
include_once("../../Config/config.php");
// TODO header call
new Header("Titulo", $DIRS, null);
$data = data_submitted();

echo <<< HTML

        <main class="form-signin w-25 p-auto m-auto">
            <form class="needs-validation" method="POST" id="dataUser" name="dataUser" action="Action/actionSession.php">
                <h1 class="h3 mb-3 fw-normal ">Please sign in</h1>

                <div class="form-floating">
                    <input type="text" class="form-control" id="usnombre" name="usnombre" placeholder="username">
                    <label for="floatingInput">Username</label>
                    <div class="invalid-feedback">Ingrese un usuario correcto</div>
                </div>
                <br>
                <div class="form-floating">
                    <input type="password" class="form-control" id="uspass" name="uspass" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    <div class="invalid-feedback">Ingrese una contraseña correcto</div>
                </div>
                <br>
                <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
            </form>
        </main>

HTML;
