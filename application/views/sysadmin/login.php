 <!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>Login Sysadmin</title>

   <link href="<?php echo sys_asset('css/bootstrap.min.css') ?>" rel="stylesheet">
   <link href="<?php echo sys_asset('css/font-awesome.css') ?>" rel="stylesheet">
   <link href="<?php echo sys_asset('css/custom.css') ?>" rel="stylesheet">
</head>
<body><div class="container">

      <form class="form-signin" role="form" method="post">
        <h2 class="form-signin-heading">Inloggen</h2>
        <? if(isset($error) && $error != ''): ?>
          <div class="alert alert-danger"><?=$error?></div>
        <? endif; ?>
        <input type="text" name="username" class="form-control" placeholder="Gebruikersnaam" value="<? if(isset( $used_username) && $used_username != ''){ echo $used_username;}?>" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me" /> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit_login_form">Sign in</button>
      </form>

    </div> <!-- /container -->
</div>
</body>
</html>