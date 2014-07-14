<?= $header; ?>
<div id="install" rel="<?= $end; ?>" >  
    <h4><?=$conf_site_title;?></h4>
    <?php if($file === false):?>
    <div class="row">
    <div class="col-md-5 col-lg-offset-1 adm-conf"> 
    <form role="form" method="POST">
        <?php if ($lang_dir !== false): ?>
            <div class="form-group">
                <select name="lang">
                    <?php foreach ($lang_dir as $langs): ?>
                        <option value="<?= $langs; ?>"><?= $langs; ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= $lang; ?></label>
            </div>
        <?php endif; ?>
        <div class="checkbox">
            <label><?= $cache; ?></label>
            <input type="checkbox" name="cache">
        </div>
        <div class="form-group">
            <label><?= $cache_time; ?></label>
            <input type="text" name="cache_time" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="form-group">
            <label><?= $session_time; ?></label>
            <input type="text" name="session_time" class="form-control" id="exampleInputPassword1">
        </div>
        <?php if ($page_dir !== false): ?>
            <div class="form-group">               
                <select name="default_page">
                    <?php foreach ($page_dir as $page): ?>
                        <option value="<?= substr($page, 0, strlen($page) - 4); ?>"><?= substr($page, 0, strlen($page) - 4); ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= $default_page; ?></label>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label><?= $ecoding_html; ?></label>
            <input type="text" name="ecoding_html" class="form-control" id="exampleInputPassword1" value="">
        </div>
        <?php if ($style_theme !== false): ?>
            <div class="form-group">              
                <select name="style">
                    <?php foreach ($style_theme as $theme): ?>
                        <option value="<?= $theme; ?>"><?= $theme; ?></option>
                    <?php endforeach; ?>
                </select>
                 <label><?= $style; ?></label>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="checkbox">
                <label><?= $display_error; ?></label>
                <input type="checkbox" name="display_error">
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label><?= $log_error; ?> </label>
                <input type="checkbox"  name="log_error">
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label><?= $time_print; ?></label>
                <input type="checkbox"  name="time_print">
            </div>
        </div>
        <button type="submit" name="edit_conf" class="btn btn-primary"><?= $button_edit; ?></button>
    </form>
    </div>
</div>
    <?php else: ?>
     <div class="box_install">
         <p><font color="green">/system/config/conf_web.php : Complete</font></p> 
    </div>
    <div class="box_continue">
        <a href="/<?=$folder;?>/start" class="btn btn-primary"><?=$btn_back;?></a>
        <a href="/<?=$folder;?>/ConfDBSite" class="btn btn-primary"><?=$btn_continue;?></a>
    </div>
    <?php endif;?>
</div>
<?= $footer; ?>
