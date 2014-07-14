<?=$header;?>
<div id="install" rel="<?= $end; ?>" > 
    <h4><?=$End_title;?></h4>
     <div class="box_install">
          <?=$msg;?>
    </div>
    <div class="box_continue">
        <?php if($edit === false): ?>
        <a href="/<?=$folder;?>/CreateAccount" class="btn btn-primary"><?=$btn_back;?></a>
       <?php else: ?>
        <a href="/<?=$folder;?>/" class="btn btn-primary"><?=$btn_load;?></a>
       <?php endif; ?>
    </div>
</div>
<?=$footer;?>

