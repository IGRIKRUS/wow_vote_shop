<?= $header; ?>
<div id="install" rel="<?= $end; ?>" >  
    <h4><?=$conf_siteDB_title;?></h4>
 <?php if($file !== true and !isset($_POST['load'])):?>
    <div class="row">
            <div class="col-md-5 col-lg-offset-1 adm-conf"> 
                <form role="form" method="POST">
                    <div class="form-group">
                        <label><?= $confDB_host; ?></label>
                        <input type="text" name="host" class="form-control"  placeholder="127.0.0.1">
                    </div>
                    <div class="form-group">
                        <label><?= $confDB_user; ?></label>
                        <input type="text" name="user" class="form-control"  placeholder="root">
                    </div>
                    <div class="form-group">
                        <label><?= $confDB_pass; ?></label>
                        <input type="text" name="pass" class="form-control"  placeholder="12345">
                    </div>
                    <div class="form-group">
                        <label><?= $confDB_port; ?></label>
                        <input type="text" name="port" class="form-control"  placeholder="3306">
                    </div>
                    <div class="form-group">
                        <label><?= $confDB_ecod; ?></label>
                        <input type="text" name="ecoding" class="form-control"  placeholder="utf8">
                    </div>
                    <div class="form-group">
                        <label><?= $confDB_base; ?></label>
                        <input type="text" name="base" class="form-control"  placeholder="vote_shop">
                    </div>
                    <div class="form-group">
                        <label><?= $confDB_pref; ?></label>
                        <input type="text" name="prefix" class="form-control"  placeholder="vote_">
                    </div>
                        <?php if ($driver): ?>
                            <div class="form-group">               
                                <select name="driver">
                                    <?php foreach ($driver as $drv): ?>
                                        <option value="<?= substr($drv, 0, strlen($drv) - 4); ?>"><?= substr($drv, 0, strlen($drv) - 4); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label><?= $confDB_driver; ?></label>
                            </div>
                        <?php endif; ?>
                    <button type="submit" name="load" class="btn btn-primary"><?=$btn_load;?></button>
                </form>
            </div>
        <div class="col-md-5" style="margin-top: 25px;">
            <?=Message('warning', $confDB_info);?>
        </div>
</div>
    <?php else: ?>
     <div class="box_install">
         <?=$form;?> 
          <?php if($file === true): ?>
         <p><font color="green">/system/config/conf_db.php : Complete</font></p>
         <?php endif; ?>
    </div>
    <div class="box_continue">
        <a href="/<?=$folder;?>/ConfSite" class="btn btn-primary"><?=$btn_back;?></a>
        <?php if($file === true): ?>
        <a href="/<?=$folder;?>/ConfServer" class="btn btn-primary"><?=$btn_continue;?></a>
        <?php else: ?>
        <a href="/<?=$folder;?>/ConfDBSite" class="btn btn-primary"><?=$btn_update;?></a>
        <?php endif; ?>
    </div>
    <?php endif;?>
</div>
<?= $footer; ?>