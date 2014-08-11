<!DOCTYPE html>
<html>
    <head lang="ru">
        <title><?= $title; ?></title>
        <meta charset="<?= $ecoding; ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/<?= $folder; ?>/app/view/<?= $style; ?>/img/wow.ico"/>
        <!-- Bootstrap core CSS -->
        <link href="/<?= $folder; ?>/app/view/<?= $style; ?>/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="/<?= $folder; ?>/app/view/<?= $style; ?>/css/style.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/<?= $folder; ?>/app/view/<?= $style; ?>/js/bootstrap.min.js"></script>
       
        <script src="/<?= $folder; ?>/app/view/<?= $style; ?>/js/script_inst.js"></script>
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
           <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container">
            <div class="row-fluid">
                <div class="span12">
                    <div class="logo"></div>
                    <div id="header">
                        <nav class="navbar navbar-inverse" role="navigation">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">  
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <a class="navbar-brand" href="#">Install</a>                
                                </div>
                                <div class="collapse navbar-collapse"  id="bs-example-navbar-collapse-1">
                                    <div class="col-md-8 inst">
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar"  role="progressbar" >
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>