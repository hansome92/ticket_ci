<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="keywords" content="">
   <meta name="author" content="">

   <title>Tibbaa CMS</title>
   <link rel="shortcut icon" type="image/x-icon" href="<?=$base?>images/favicon.ico"/>

   <link href="<?php echo sys_asset('css/bootstrap.min.css') ?>" rel="stylesheet">
   <link href="<?php echo sys_asset('css/font-awesome.css') ?>" rel="stylesheet">
   <link href="<?php echo sys_asset('css/custom.css') ?>" rel="stylesheet">
   <link href="<?php echo sys_asset('css/priorities.css') ?>" rel="stylesheet">
   <link href="http://code.jquery.com/ui/jquery-ui-git.css" rel="stylesheet">
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Tibbaa Sysadmin</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?=sys_url();?>">Dashboard</a></li>
            <li><a href="<?=sys_url('settings');?>">Settings</a></li>
            <li><a href="<?=base_url('logout');?>">Uitloggen</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>
	<div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="<?=sys_url();?>">Dashboard</a></li>
            <li><a href="<?=sys_url('translation');?>">Vertalingen</a></li>
            <li><a href="<?=sys_url('sponsorships');?>">Sponsoren</a></li>
            <li><a href="<?=sys_url('categories');?>">Event categorieen</a></li>
            <li><a href="<?=sys_url('wizards');?>">Wizards</a></li>
          </ul>
        </div>
		
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<?php if(isset($this->notifications->notifications)): foreach ($this->notifications->notifications as $key => $val): ?>
				<div class="alert alert-<?=(isset($val[1]) ? $val[1] : "info");?>"><?=$val[0];?></div>
			<?php endforeach; endif; ?>
