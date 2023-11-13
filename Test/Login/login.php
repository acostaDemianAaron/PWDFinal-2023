<?php
include_once("../../Config/config.php");
// TODO header call
new Header("Titulo", $DIRS, null);
$data = data_submitted();

if (count($data) > 0) {
    if (isset($data['msg']) || isset($data['msgError'])) {
        if (isset($data['msg'])) {
            $msg = $data['msg'];
            $error = "success";
        } else {
            $message = $data['messageErr'];
            $error = "msgError";
        }
    }
}

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
            <!-- <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script> -->
            <!-- <script src="https://cdn.jsdelivr.net/npm/sweeterror2@10"></script> -->

            <!-- <script src="session.js"></script> -->
        </main>

HTML;
