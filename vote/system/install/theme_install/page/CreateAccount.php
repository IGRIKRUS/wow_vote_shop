<?= $header; ?>
<div id="install" rel="<?= $end; ?>" >  
    <h4><?= $CAcc_title; ?></h4>
    <div class="row">
        <?php if (isset($msg) !== true): ?>
            <?php if (!isset($_POST['send'])): ?>
                <div class="col-md-5 col-lg-offset-1">
                    <form method="POST" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="login" class="form-control" placeholder="<?= $input_name; ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" name="pass" class="form-control" placeholder="<?= $input_pass; ?>">
                        </div>
                        <div class="form-group">
                            <?php if ($select_servers): ?>
                                <select name="serv" class="form-control">
                                    <option><?= $select_serv; ?> </option>
                                    <?php foreach ($select_servers as $key => $val): ?>
                                        <option value="<?= $key; ?>"><?= $val['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <input type="password" name="adm_pass" class="form-control" placeholder="<?= $CAcc_admin; ?>">
                        </div>
                        <button type="submit" name="send" class="btn btn-primary"><?= $btn_load; ?></button>
                    </form>
                </div>
                <div class="col-md-5">
                    <?= Message('warning', $ACcc_msg_txt); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <div class="col-md-12">
            <?php if ($account !== false || isset($_POST['send'])): ?>
                <?php if (isset($message) and $message == true): ?>
                    <?= $message; ?>
                    <?php endif; ?>
                <?php if(isset($msg)): ?>
                    <div class="box_install">
                        <?= $msg; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div class="box_continue">
                <a href="/<?= $folder; ?>/CreateTable" class="btn btn-primary"><?= $btn_back; ?></a>
                <?php if (isset($_POST['send'])): ?>
                    <a href="/<?= $folder; ?>/CreateAccount" class="btn btn-primary"><?= $btn_update; ?></a>
                <?php endif; ?>
                <?php if ($account !== false): ?>
                    <a href="/<?= $folder; ?>/EndInstall" class="btn btn-primary"><?= $btn_continue; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $footer; ?>

