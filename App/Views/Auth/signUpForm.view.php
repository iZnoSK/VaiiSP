<div class="container">
    <div class="row">
        <div class="col-10 offset-1 col-md-8 offset-md-2  col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-3">
            <!-- Formulár na zaregistrovanie sa -->
            <form method="post" action="?c=auth&a=signUp">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-5">
                        <h5><strong>Registrácia</strong></h5>
                    </div>
                    <!-- časti formuláru -->
                    <div>
                        <!-- TODO obrazok? -->
                        <!-- Login -->
                        <div class="form-control mb-3">
                            <label for="login" class="form-label"><strong>Login</strong></label>
                            <input id="login" class="form-control" name="loginOfUser" type="text" required>
                        </div>
                        <!-- Email -->
                        <div class="form-control mb-3">
                            <label for="mail" class="form-label"><b>E-mail</b></label>
                            <input id="mail" class="form-control" name="emailOfUser" type="email" placeholder="priklad@gmail.com" required>
                        </div>
                        <!-- Heslo -->
                        <div class="form-control mb-3">
                            <label for="pwd" class="form-label"><strong>Heslo</strong></label>
                            <input id="pwd" class="form-control" name="passwordOfUser" type="password" required>
                        </div>
                        <!-- Potvrdzovacie heslo -->
                        <div class="form-control mb-3">
                            <label for="repeatedPwd" class="form-label"><b>Potvrdzovacie heslo</b></label>
                            <input id="repeatedPwd" class="form-control" name="repeatedPasswordOfUser" type="password" required>
                        </div>
                        <!-- tlačítko -->
                        <div class="mb-3">
                            <button id="submit" class="btn btn-primary" type="submit">Zaregistrovať sa</button>
                        </div>
                        <!--  -->
                    </div>
                    <!--  -->
                </div>
            </form>
            <!--  -->
        </div>
    </div>
</div>