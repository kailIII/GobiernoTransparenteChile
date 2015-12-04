<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title>Transparencia Activa - Login</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css">
            .login { width:250px; margin:100px auto; }
            legend { margin-bottom:10px; }
            .error { color:#f00; }
        </style>
    </head>
    <body>
        <div class="login">
            <div class="error">
                <?php
                echo validation_errors();
                if(isset($message))
                    echo '<p>'.$message.'</p>';
                ?>
            </div>
            <form method="post" action="<?php echo site_url('usuarios/login')?>">
                <legend><strong>Acceso Gobiernotransparentechile</strong></legend>
                <table class="formTable">
                    <tr>
                        <td>
                            <label>Usuario</label>
                        </td>
                        <td>
                            <input type="text" name="usuario" value="<?php echo set_value('usuario') ?>" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password</label>
                        </td>
                        <td>
                            <input type="password" name="password" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">
                            <input type="submit" value="Login" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>