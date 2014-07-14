<?= $head; ?>
<?= $header; ?>
<h4><?=$title_create;?></h4>
<?php if($server_list !== false): ?>
<div class="row">
<form class="col-md-8 col-lg-offset-1 adm-create" method="POST">
  <div class="form-group">
    <input type="text" name="name"  placeholder="ID или Название">
  
    <select name="serv">
        <?php foreach ($server_list as $key => $val):?>
            <option value="<?=$key;?>"><?=$val['name'];?></option>
        <?php endforeach;?>
    </select>
    <select name="count">
        <option value="10">10</option>
        <option value="30">30</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </select>
  <button type="submit" name="send_search" class="btn btn-primary">Поиск</button>
  </div>
</form>
<?php else: ?>
<?=$msg_serv_list;?>
<?php endif; ?>
<div class="col-md-12">
    <?php if(!is_array($item_search_list)): ?>
    <?=$item_search_list;?>
    <?php endif; ?>
    
<?php if (is_array($item_search_list)): ?>
    <form method="POST">
        <div class="table-responsive">
            <table id="tooltips" class="table table-striped adm-table">
                <tr>
                    <td>ID</td>
                    <td>Название</td>
                    <td>Цена(Vp)</td>
                    <td>Количество</td>
                </tr>
                <?php foreach ($item_search_list as $items): ?>
                    <tr>
                        <td><?= $items['entry']; ?></td>
                        <td rel="items_<?= $items['id_realm']; ?>_<?= $items['entry']; ?>"><?= $items['item_name']; ?></td>
                        <td><input name="Vp_<?= $items['entry']; ?>" type="text" placeholder="0"></td>
                        <td><input name="Cn_<?= $items['entry']; ?>" type="text"  placeholder="0"></td>                       
                        <td><button class="btn btn-primary" name="create" type="submit" value="<?= $items['entry']; ?>_<?= $items['id_realm']; ?>"><span class="glyphicon glyphicon-plus"></span></button></td>
                    </tr>                 
                <?php endforeach; ?> 
            </table>
        </div>
    </form> 
    <?php endif; ?>
</div>
</div>
<?= $footer;?>