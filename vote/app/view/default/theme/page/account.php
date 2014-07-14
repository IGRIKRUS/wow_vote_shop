
<?=$head;?>
<?=$header;?>
<div id="content" class="account">
    <h3><?=$settings_name;?></h3>
    <div class="row">
        <div class="col-md-4 col-lg-offset-1">
            <h4><?=$new_password;?></h4>
            <p style="color:#912F2F;">
                <?=$warning_message;?><br/>
            </p>
            <form role="form" method="POST">
                <div class="form-group">
                    <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="<?=$input_password;?>">
                </div>
                <div class="form-group">
                    <input type="password" name="newpass" class="form-control" id="exampleInputPassword1" placeholder="<?=$input_newpassword;?>">
                </div>
                <div class="form-group">
                    <input type="password" name="renewpass" class="form-control" id="exampleInputPassword1" placeholder="<?=$input_renewpassword;?>">
                </div>
                <button type="submit" name="editpass" class="btn btn-primary"><?=$button_edit;?></button>
            </form>
        </div>
        <div class="col-md-4 col-lg-offset-2">
            <h4><?=$characters;?></h4>
            <table class="table table-striped">
                <?php if(is_array($characters_list)): ?>
                <?php foreach ($characters_list as $val) : ?>
                <tr>
                    <td><?=$val['char_name'];?></td><td style="width: 10px;"><a href="/<?=$folder;?>/account/delet/<?=$val['id'];?>"><span class="glyphicon glyphicon-remove"></span></a></td>        
                </tr>
                <?php endforeach;?>                       
                <?php else: ?>
                <tr>
                    <td><?=$characters_null;?></td>        
                </tr>
                <?php endif; ?>
            </table>
            <form role="form" method="POST">
            <button type="submit" name="update" class="btn btn-primary"><?=$update_characters_botton;?></button>
        </form>
        </div> 
    </div>
</div>
<?=$footer;?>

