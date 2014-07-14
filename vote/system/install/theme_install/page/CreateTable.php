<?=$header;?>
<div id="install" rel="<?= $end; ?>" >  
    <h4><?=$CRtable_title;?></h4>
    <div class="box_install">
        <?=$msg;?>
    </div>
    <div class="col-md-12">
        <div class="box_continue">
        <a href="/<?=$folder;?>/ConfServer" class="btn btn-primary"><?=$btn_back;?></a>
        <?php if($tables === true):?>
        <a href="/<?=$folder;?>/CreateAccount" class="btn btn-primary"><?=$btn_continue;?></a>
        <?php endif;?>
        </div>
    </div>
</div>
<?=$footer;?>
