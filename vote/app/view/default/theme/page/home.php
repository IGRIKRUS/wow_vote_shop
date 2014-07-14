<?=$head;?>
<?=$header;?>
<div id="content">
    <div class="tabbable tabs-left">
        <ul class="nav nav-tabs">
            <?php
                  $new = '';
                  $wep = '';
                   if ($item_news !== false) {
                       $new = 'active';
                   } else {
                       $wep = 'active';
                   }
            ?>
            <li class="<?=$new;?>"><a href="#A" data-toggle="tab"><?=$news;?></a></li>
            <li class="<?=$wep;?>"><a href="#B" data-toggle="tab"><?=$weapon;?></a></li>
            <li class=""><a href="#C" data-toggle="tab"><?=$armor;?></a></li>
            <li class=""><a href="#D" data-toggle="tab"><?=$mounts;?></a></li>
            <li class=""><a href="#E" data-toggle="tab"><?=$defold;?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane <?=$new;?>" id="A">
                <div class="shop_item_list">
                    <?php if($item_news !== false): ?>
                    <?=$item_news;?>
                    <?php else: ?>
                    <?=$msg_news;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane <?=$wep;?>" id="B">
                <div class="shop_item_list">
                    <?php if($item_weapon !== false): ?>
                    <?=$item_weapon;?>
                    <?php else: ?>
                    <?=$msg_all;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane" id="C">
                <div class="shop_item_list">                 
                    <?php if($item_armor !== false): ?>
                    <?=$item_armor;?>
                    <?php else: ?>
                    <?=$msg_all;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane" id="D">
                <div class="shop_item_list">                   
                    <?php if($item_mount !== false): ?>
                    <?=$item_mount;?>
                    <?php else: ?>
                    <?=$msg_all;?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane" id="E">
                <div class="shop_item_list">                   
                    <?php if($item_different !== false): ?>
                    <?=$item_different;?>
                    <?php else: ?>
                    <?=$msg_all;?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?=$footer;?>

