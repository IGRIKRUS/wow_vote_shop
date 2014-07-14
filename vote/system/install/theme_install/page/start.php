<?= $header; ?>
<div id="install" rel="<?= $end; ?>" >  
    <h4><?=$start_title;?></h4>
    <div class="box_install">
        <p>/system/log : <?=$log;?></p>
        <p>/system/cache : <?=$cache;?></p>
        <p>/system/config : <?=$conf;?></p> 
    </div>
    <?php if($continue != 1):?>
        <?php dump($continue); ?>
    <?php else: ?> 
    <div class="box_continue">
        <a href="/<?=$folder;?>/ConfSite" class="btn btn-primary"><?=$btn_continue;?></a>
    </div>
    <?php endif; ?>
</div>
<?= $footer; ?>