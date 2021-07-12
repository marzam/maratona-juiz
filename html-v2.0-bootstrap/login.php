<?php
include 'vars.php';
include 'p-judge-lib.php';
?>
<!doctype html>
    <?php printHeader(); ?>
    <body>
        <div class="text-center">
            <img class="mt-4 mb-4" height="128" src="img/ufrrj.png" alt="Logo">
            <form method="post" id="id_login" action="dologin.php" >
                <div>
                    <div> <input id="idLogin" name="idLogin" type="text" placeholder="username" required autofocus> </div>
                    <div> <input id="idPasswd" name="idPasswd" type="password"  placeholder="password" > </div>
                </div>
                <p class="mt-4"> <input class = "btn btn-lg btn-dark btn-block" value="Logar" type="submit"> </p>
                <p > <a href="javascript:forgot_password()">esqueceu sua senha ?</a> </p>
            </form>

        </div>
    </body>
</html>
