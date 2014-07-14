<?= $head; ?>
<?= $header; ?>
<h4><?= $title_cfg_site; ?></h4>
<div class="col-md-5 col-lg-offset-1 adm-conf"> 
    <form role="form" method="POST">
        <?php if ($lang_dir !== false): ?>
            <div class="form-group">
                <select name="lang">
                    <?php foreach ($lang_dir as $langs): ?>
                        <option <?php if ($langs == $conf->lang) echo 'selected disabled'; ?> value="<?= $langs; ?>"><?= $langs; ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= $lang; ?></label>
            </div>
        <?php endif; ?>
        <div class="checkbox">
            <label><?= $cache; ?></label>
            <input type="checkbox" name="cache" <?php if ($conf->cache == true) echo 'checked'; ?>>
        </div>
        <div class="form-group">
            <label><?= $cache_time; ?></label>
            <input type="text" name="cache_time" class="form-control" id="exampleInputPassword1" value="<?= $conf->cache_time ?>">
        </div>
        <div class="form-group">
            <label><?= $session_time; ?></label>
            <input type="text" name="session_time" class="form-control" id="exampleInputPassword1" value="<?= $conf->session_time ?>">
        </div>
        <?php if ($page_dir !== false): ?>
            <div class="form-group">               
                <select name="default_page">
                    <?php foreach ($page_dir as $page): ?>
                        <option <?php if ($page == $conf->default_page) echo 'selected disabled'; ?> value="<?= substr($page, 0, strlen($page) - 4); ?>"><?= substr($page, 0, strlen($page) - 4); ?></option>
                    <?php endforeach; ?>
                </select>
                <label><?= $default_page; ?></label>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label><?= $ecoding_html; ?></label>
            <input type="text" name="ecoding_html" class="form-control" id="exampleInputPassword1" value="<?= $conf->ecoding_html ?>">
        </div>
        <?php if ($style_theme !== false): ?>
            <div class="form-group">              
                <select name="style">
                    <?php foreach ($style_theme as $theme): ?>
                        <option <?php if ($theme == $conf->style) echo 'selected disabled'; ?> value="<?= $theme; ?>"><?= $theme; ?></option>
                    <?php endforeach; ?>
                </select>
                 <label><?= $style; ?></label>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <div class="checkbox">
                <label><?= $display_error; ?></label>
                <input type="checkbox" name="display_error" <?php if ($conf->display_error == true) echo 'checked'; ?>>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label><?= $log_error; ?> </label>
                <input type="checkbox"  name="log_error" <?php if ($conf->log_error == true) echo 'checked'; ?>>
            </div>
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label><?= $time_print; ?></label>
                <input type="checkbox"  name="time_print" <?php if ($conf->time_print == true) echo 'checked'; ?>>
            </div>
        </div>
        <button type="submit" name="edit_conf" class="btn btn-primary"><?= $button_edit; ?></button>
    </form>
</div>
<?= $footer; ?>