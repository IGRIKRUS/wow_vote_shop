<div id="Messager">
    <?=$message; ?>
</div>

<div id="header">
    <h4>Admin Panel</h4>
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
                <a class="navbar-brand" href="/<?=$folder;?>/admin"><span class="glyphicon glyphicon-home"></span></a>                
            </div>
            <div class="collapse navbar-collapse"  id="bs-example-navbar-collapse-1">

                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                       <li><a href="/<?=$folder;?>/"><?=$site;?></a></li> 
                       <li><a href="/<?=$folder;?>/admin/quit"><?=$exit;?></a></li>                  
                    </ul>
                </div>         
            </div>
        </div>
    </nav>
</div>
<div id="content" class="admin">
<div class="row"> 
<div class="col-md-2 nav-admin">
<div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <?=$item_title;?>
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse <?php if($item_list_act || $item_create_act) echo 'in'; ?>">
      <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
              <li class="<?php if($item_list_act) echo 'active'; ?>" ><a href="/<?=$folder;?>/admin/Itemlist"><?=$item_list;?></a></li>
              <li class="<?php if($item_create_act) echo 'active'; ?>" ><a href="/<?=$folder;?>/admin/ItemCreate"><?=$item_create;?></a></li>
          </ul>
      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
            <?=$adm_config;?>
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse <?php if($ConfigServer || $ConfigSite || $AddAdm || $Cache) echo 'in'; ?>">
      <div class="panel-body">
          <ul class="nav nav-pills nav-stacked">
              <li class="<?php if($AddAdm)  echo 'active'; ?>" ><a href="/<?=$folder;?>/admin/AddAdm"><?=$adm_create;?></a></li>
              <li class="<?php if($ConfigSite) echo 'active'; ?>" ><a href="/<?=$folder;?>/admin/ConfigSite"><?=$adm_cfg_site;?></a></li>
              <li class="<?php if($Cache) echo 'active'; ?>" ><a href="/<?=$folder;?>/admin/Cache"><?=$adm_cfg_cache;?></a></li>
          </ul>
      </div>
    </div>
  </div>
</div>
</div>
    <div class="col-md-10 content-admin">
