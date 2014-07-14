<?= $head; ?>
<?= $header; ?>
<h4><?=$title_list;?></h4>
<?php if ($item !== false): ?>
    <form method="POST">
        <div class="table-responsive">
            <table id="tooltips" class="table table-striped adm-table">
                <tr>
                    <td>ID</td>
                    <td>Название</td>
                    <td>Realm</td>
                    <td>Цена(Vp)</td>
                    <td>Количество</td>
                    <td>Статус</td>
                </tr>
                <?php for($i =1;$i <= count($item);$i++): ?>
                
                <?php foreach ($item[$i] as $items): ?>
                    <tr>
                        <td><?= $items['id_lot']; ?></td>
                        <td rel="item_<?= $items['realm_id']; ?>_<?= $items['entry']; ?>"><?= $items['item_name']; ?></td>
                        <td><?= $items['server_name']; ?></td>
                        <td><input name="Vp_<?= $items['id_lot']; ?>" type="text" placeholder="<?= $items['price_Vp']; ?>"></td>
                        <td><input name="Cn_<?= $items['id_lot']; ?>" type="text"  placeholder="<?= $items['price_count']; ?>"></td>                       
                        <td>
                            <select name="Lc_<?= $items['id_lot']; ?>">
                                <option <?php if($items['Locked'] > 0) echo 'selected disabled' ?> value="1"><?= $Locked_false; ?></option>
                                <option <?php if($items['Locked'] == 0) echo 'selected disabled' ?> value="0"><?= $Locked_true; ?></option>
                            </select>
                        </td>
                        <td><button class="btn btn-primary" name="edit" type="submit" value="<?= $items['id_lot']; ?>_<?= $items['realm_id']; ?>"><span class="glyphicon glyphicon-pencil"></span></button></td>
                        <td><button class="btn btn-primary" name="delete"type="submit" value="<?= $items['id_lot']; ?>_<?= $items['realm_id']; ?>"><span class="glyphicon glyphicon-trash"></span></button></td>
                    </tr>                 
                <?php endforeach; ?> 
                    <?php endfor; ?>
            </table>
        </div>
    </form>
<?php else: ?>
    <?= $msg_null; ?>
<?php endif; ?>
<?= $footer; ?>

