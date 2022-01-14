<?php /**@var Array $data */ ?>
<div class="container">
    <div class="row">
        <div class="col-10 offset-1 col-md-8 offset-md-2  col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-3">
            <!-- Formulár na prihlásenie sa -->
            <form method="post" action="?c=auth&a=login">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Prihlásenie</strong></h5>
                    </div>
                    <!-- časti formuláru -->
                    <div>
                        <!-- error hláška, ak sme zadali zlý login alebo heslo -->
                        <?php if($data['error'] != "") { ?>
                            <div class="alert alert-danger alert-dismissible text-center">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?= $data['error'] ?>
                            </div>
                        <?php } ?>
                        <!-- Login -->
                        <div class="form-control mb-3">
                            <label for="login" class="form-label"><strong>Používateľské meno</strong></label>
                            <input id="login" class="form-control" name="loginOfUser" type="text" required>
                        </div>
                        <!-- Heslo -->
                        <div class="form-control mb-3">
                            <label for="pwd" class="form-label"><strong>Heslo</strong></label>
                            <input id="pwd" class="form-control" name="passwordOfUser" type="password" required>
                        </div>
                        <!-- tlačítko -->
                        <div class="mb-3">
                            <button id="submit" class="btn btn-primary" type="submit">Prihlásiť sa</button>
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
