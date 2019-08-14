<?php include_once 'header.html.php';?>
<div class="container-fluid" xmlns="http://www.w3.org/1999/html">
    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>Вход в систему</h1>
    </div>
    <div class="row">
        <div class="col-12 d-flex flex-column align-items-center">
            <form action="" method="post">
                <div class="form-group">
                    <div class="p2">
                        <input type="text" name="username" placeholder="Имя пользователя" class="form-control" >
                    </div>
                    <div class="p2">
                        <input type="password" name="password" id="password" placeholder="Пароль" class="form-control" >
                    </div>
                    <div class="row d-flex justify-content-center">
                    <div class="p2">
                        <label class="form-check-label">
                            <input type="checkbox" id="show" class="form-check-input" value="">Показать
                        </label>
                        </div>
                        <div class="p2">
                        <label class="form-check-label">
                            <input type="checkbox" id="remember" class="form-check-input" value="" name="remember">Запомнить
                        </label>
                    </div>
                    </div>
                    <div class="p2">
                        <input type="submit" value="Войти" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once 'footer.html.php';?>
