<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta name="google-signin-client_id" content="411629528420-k2c3q9oj23vsre92crfqou9ked5jk6ls.apps.googleusercontent.com"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <title>Login</title>
</head>

<body>
    <main id="app">
        <div class="container">
            <form @submit.prevent="SubmitLogin">
                <div class="card row col-5 mx-auto mt-5 p-4">
                    <div class="col-12">
                        <input type="email" v-model="form_email" class="form-control form-control-sm" placeholder="Correo Electronico" required>
                    </div>
                    <div class="col-12 mt-2">
                        <input type="password" v-model="form_password" class="form-control form-control-sm" placeholder="Contraseña" required>
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn-theme-2 btn-modal-login mt-3" type="submit">Iniciar Sesion</button>
                    </div>
                    <div class="line-login-divider">
                        <hr />
                    </div>
                    <div class="col-12 mt-2">
                        <button class="btn-theme-facebook btn-modal-login" type="reset" @click="logInWithFacebook">
                            <i class="fab fa-facebook fa-lg mr-2"></i>
                            Facebook
                        </button>
                    </div>
                    <div class="col-12">
                        <button class="btn-theme-google btn-modal-login mt-2" type="reset" @click="SubmitLoginRS(2)">
                            <i class="fab fa-google-plus-g fa-lg mr-2"></i>
                            Google
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
    <script src="assets/axios.js"></script>
    <script src="assets/main.js"></script>
    
</body>

</html>