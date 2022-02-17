<?php
$title = "Registrácia | ";
?>

<?php /**@var Array $data */ ?>
<div class="container">
    <div class="row">
        <div class="col-10 offset-1 col-md-8 offset-md-2  col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-3">
            <!-- Formulár na zaregistrovanie sa -->
            <form method="post" action="?c=auth&a=signUp" enctype="multipart/form-data">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Registrácia</strong></h5>
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
                            <input id="login" class="form-control" name="loginOfUser" type="text" minlength="3" maxlength="20" required>
                        </div>
                        <!-- Email -->
                        <div class="form-control mb-3">
                            <label for="mail" class="form-label"><strong>E-mail</strong></label>
                            <input id="mail" class="form-control" name="emailOfUser" type="email" placeholder="priklad@gmail.com" required>
                        </div>
                        <!-- obrázok -->
                        <div class="form-control mb-3">
                            <label for="formFile" class="form-label"><strong>Obrázok</strong></label>
                            <input id="formFile" class="form-control" name="fileOfUser" type="file">
                        </div>
                        <!-- Heslo -->
                        <div class="form-control mb-3">
                            <label for="pwd" class="form-label"><strong>Heslo</strong></label>
                            <input id="pwd" class="form-control" name="passwordOfUser" type="password" minlength="8" required>
                        </div>
                        <!-- Potvrdzovacie heslo -->
                        <div class="form-control mb-3">
                            <label for="repeatedPwd" class="form-label"><b>Potvrdzovacie heslo</b></label>
                            <input id="repeatedPwd" class="form-control" name="repeatedPasswordOfUser" type="password" minlength="8" required>
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