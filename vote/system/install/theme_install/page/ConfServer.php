<?= $header; ?>
<div id="install" rel="<?= $end; ?>" >  
    <h4><?=$conf_server_title;?></h4>
    <?php if($msg != ''):?>
    <div class="box_install">
         <?=$msg;?> 
    </div>
    <?php endif; ?>
        <div class="row">
            <div class="col-md-5 col-lg-offset-1 adm-conf"> 
                <form role="form" method="POST">
                    <h4><?=$conf_server_name;?></h4>
                    <div class="form-group">
                        <label><?=$confSV_ID;?></label>
                        <input type="text" name="id" class="form-control"  placeholder="ID">
                    </div>
                    <h4><?=$conf_server_DB;?></h4>
                    <div class="form-group">
                        <label><?=$confDB_host;?></label>
                        <input type="text" name="host" class="form-control"  placeholder="127.0.0.1">
                    </div>
                    
                    <div class="form-group">
                        <label><?=$confDB_user;?></label>
                        <input type="text" name="user" class="form-control"  placeholder="root">
                    </div>
                    
                    <div class="form-group">
                        <label><?=$confDB_pass;?></label>
                        <input type="text" name="pass" class="form-control"  placeholder="12345">
                    </div>
                    
                    <div class="form-group">
                        <label><?=$confDB_port;?></label>
                        <input type="text" name="port" class="form-control"  placeholder="3306">
                    </div>
                    
                    <div class="form-group">
                        <label><?=$confDB_ecod;?></label>
                        <input type="text" name="ecoding" class="form-control"  placeholder="utf8">
                    </div>
                    
                    <div class="form-group">
                        <label><?=$confSV_auth;?></label>
                        <input type="text" name="auth" class="form-control"  placeholder="auth">
                    </div>  
                    
                    <div class="form-group">
                        <label><?=$confSV_characters;?></label>
                        <input type="text" name="characters" class="form-control"  placeholder="characters">
                    </div> 
                    
                    <div class="form-group">
                        <label><?=$confSV_world;?></label>
                        <input type="text" name="world" class="form-control"  placeholder="world">
                    </div> 
                    <h4><?=$conf_server_vote;?></h4>
                     <div class="form-group">
                        <label><?=$confSV_vote;?></label>
                        <input type="text" name="Vp_vote" class="form-control"  placeholder="10">
                    </div>
                     <div class="form-group">
                        <label><?=$confSV_sms;?></label>
                        <input type="text" name="Vp_sms" class="form-control"  placeholder="20">
                    </div>
                    <div class="form-group">
                        <label><?=$confSV_file;?></label>
                        <input type="text" name="mmotop_file" class="form-control"  placeholder="http://mmotop.ru/file/234523452345.txt">
                    </div>
                     <h4><?=$conf_server_soap;?></h4>
                      <div class="form-group">
                        <label><?=$confSV_soap_host;?></label>
                        <input type="text" name="soap_host" class="form-control"  placeholder="127.0.0.1">
                    </div>
                      <div class="form-group">
                        <label><?=$confSV_soap_port;?></label>
                        <input type="text" name="soap_port" class="form-control"  placeholder="7878">
                    </div>
                      <div class="form-group">
                        <label><?=$confSV_soap_login;?></label>
                        <input type="text" name="soap_login" class="form-control"  placeholder="user">
                    </div>
                      <div class="form-group">
                        <label><?=$confSV_soap_pass;?></label>
                        <input type="text" name="soap_pass" class="form-control"  placeholder="pass">
                    </div>
                      <div class="form-group">
                        <label><?=$confSV_soap_send_title;?></label>
                        <input type="text" name="soap_title" class="form-control"  placeholder="Vote Shop">
                    </div>
                       <div class="form-group">
                        <label><?=$confSV_soap_send_text;?></label>
                        <input type="text" name="soap_text" class="form-control"  placeholder="text">
                    </div>
                    <button type="submit" name="load" class="btn btn-primary"><?=$btn_load;?></button>
                </form>
            </div>
        <div class="col-md-5" style="margin-top: 25px;">
            <?=Message('warning', $confSV_message);?>
        </div>
    <div class="col-md-12">
        <div class="box_continue">
        <a href="/<?=$folder;?>/ConfSite" class="btn btn-primary"><?=$btn_back;?></a>
        <a href="/<?=$folder;?>/CreateTable" class="btn btn-primary"><?=$btn_continue;?></a>
        </div>
    </div>
</div>
    </div>
<?= $footer; ?>

