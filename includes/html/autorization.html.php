<?php include 'autorizationheader.html.php';?>
<div class="container-fluid" xmlns="http://www.w3.org/1999/html">
    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>Вход в систему</h1>
    </div>
    <div class="row">
        <div class="col-12 d-flex flex-column align-items-center">
            <form action="" method="post" class="was-validated" >
                <div class="form-group">
                    <div class="p2">
                        <input type="text" name="username" placeholder="Имя пользователя" class="form-control" minlength="1" required>
                    </div>
                    <div class="p2">
                        <input type="password" name="password" id="password" placeholder="Пароль" class="form-control" minlength="1" required>
                    </div>
                    <div class="row d-flex justify-content-center">
                    <div class="p2">
                        <label class="form-check-label">
                            <input type="checkbox" id="show" class="form-check-input" value="">Показать
                        </label>
                        </div>
                        <div class="p2">
                        <label class="form-check-label">
                            <input type="hidden" name="remember" value="0">
                            <input type="checkbox" id="remember" class="form-check-input" value="1" name="remember">Запомнить
                        </label>
                    </div>
                    </div>
                    <div class="p2">
                        <input type="hidden" name="csrftoken" value="<?php echo $csrfToken;?>">
                        <input type="submit" value="Войти" class="btn btn-success" name="submit_login">

                    </div>
                    <div class="errortext"><?php echo $invalidFeedback ?></div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="../includes/html/admin.js"></script>
<?php include 'footer.html.php';?>
