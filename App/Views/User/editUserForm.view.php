<?php
$title = "Úprava užívateľa | ";
?>

<?php /**@var Array $data */ ?>
<div class="container">
    <div class="row">
        <div class="col-10 offset-1 col-md-8 offset-md-2  col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 mt-3">
            <!-- Formulár na zaregistrovanie sa -->
            <form method="post" action="?c=user&a=editUser" enctype="multipart/form-data">
                <div class="form-control bg-light mb-3">
                    <!-- Nadpis -->
                    <div class="mb-4">
                        <h5><strong>Úprava účtu</strong></h5>
                    </div>
                    <!-- časti formuláru -->
                    <div>
                        <!-- error hláška -->
                        <?php if($data['error'] != "") { ?>
                            <div class="alert alert-danger alert-dismissible text-center">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <?= $data['error'] ?>
                            </div>
                        <?php } ?>
                        <!-- obrázok -->
                        <div class="form-control mb-3">
                            <label for="formFile" class="form-label"><strong>Obrázok</strong></label>
                            <input id="formFile" class="form-control" name="fileOfUser" type="file">
                        </div>
                        <!-- Heslo -->
                        <div class="form-control mb-3">
                            <label for="oldPassword" class="form-label"><strong>Staré heslo</strong></label>
                            <input id="oldPassword" class="form-control" name="oldPasswordOfUser" type="password" required>
                        </div>
                        <!-- Heslo -->
                        <div class="form-control mb-3">
                            <label for="newPassword" class="form-label"><strong>Nové heslo</strong></label>
                            <input id="newPassword" class="form-control" name="newPasswordOfUser" type="password" required>
                        </div>
                        <!-- Potvrdzovacie heslo -->
                        <div class="form-control mb-3">
                            <label for="repeatedPwd" class="form-label"><b>Potvrdzovacie heslo</b></label>
                            <input id="repeatedPwd" class="form-control" name="repeatedPasswordOfUser" type="password" required>
                        </div>
                        <!-- tlačítko -->
                        <div class="mb-3">
                            <button id="submit" class="btn btn-primary" type="submit">Uložiť zmeny</button>
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