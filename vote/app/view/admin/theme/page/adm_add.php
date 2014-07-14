<?= $head; ?>
<?= $header; ?>
<h4><?=$title_adm_add;?></h4>
<div class="row adm-add">
    <div class="col-md-3 col-lg-offset-1">
        <h5><?=$list_adm;?></h5>
        <table class="table table-striped">
            <?php if($list !==false): ?>
            <?php foreach($list as $adm): ?>
            <tr>
                <td><?=$adm['name'];?></td><td style="width: 10px;"><a href="/<?=$folder;?>/admin/AddAdm/del/<?=$adm['id'];?>"><span class="glyphicon glyphicon-remove"></span></a></td>        
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>        
        </table>
    </div>
    <div class="col-md-5 col-lg-offset-2">
        <h5><?=$create_adm;?></h5>
        <form method="POST" autocomplete="Off">
            <div class="form-group">
                <input type="text" name="id" class="form-control" id="exampleInputPassword1" placeholder="<?=$input_id;?>">
            </div>
            <div class="form-group">
                <input type="password" name="pass" class="form-control" id="exampleInputPassword1" placeholder="<?=$input_pass;?>">
            </div>
            <div class="form-group">
                <input type="password" name="repass" class="form-control" id="exampleInputPassword1" placeholder="<?=$input_repass;?>">
            </div>
            <button type="submit" name="addAdm" class="btn btn-primary"><?=$button_create;?></button>          
        </form>
    </div>
</div>
<?= $footer;?>