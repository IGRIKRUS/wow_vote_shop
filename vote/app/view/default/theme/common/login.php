<ul class="nav navbar-nav navbar-right">
        <li><a href="#"><div class="price"><?=$Vp;?> <span class="Vp">V</span>p</div></a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$name;?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="/<?=folder();?>/account/settings"><span class="glyphicon glyphicon-cog"></span> <?=$settings;?></a></li>
            <li><a href="/<?=folder();?>/cart"><span class="glyphicon glyphicon-shopping-cart"></span> <?=$cart;?>  (<?=$count;?>) <?=$Vp_sum;?> <span class="Vp">V</span>p</a></li>
            <li class="divider"></li>           
            <li><a href="/<?=folder();?>/home/quit"><span class="glyphicon glyphicon-log-out"></span> <?=$exit;?></a></li>
            <?php if($admin) :?>
            <li class="divider"></li>
            <li><a href="/<?=folder();?>/admin"><span class="glyphicon glyphicon-log-in"></span> <?=$admin;?></a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>

