<?=$head;?>
<?=$header;?>
<div id="content" class="item_info">
    <div class="row">
        <div class="col-md-5 box_info">
            <h4><?=$item_name;?></h4>
            <table class="table table-striped">
                <tr>
                    <td><?=$realm_item;?></td><td><?=$realm;?></td>
                </tr>
                <tr>
                    <td><?=$price_item;?></td><td><?=$price;?> <span class="Vp">V</span>p</td>
                </tr>
                <tr>
                    <td><?=$count_item;?></td><td> <?=$count;?></td>
                </tr>
            </table>
            <?php if($session !== false): ?>
            <form class="form-inline" role="form" method="POST">
                <div class="form-group">
                    <input type="text" name="count" class="form-control" id="exampleInputEmail2" placeholder="<?=$input_count;?>">
                </div>
                <button type="submit" name="send_item" class="btn btn-small btn-primary"><?=$botton_item_cart;?></button>
            </form>
            <?php else: ?>
            <?=$message_session;?>
            <?php endif; ?>
        </div>
        <div class="col-md-5 col-lg-offset-2 box_tooltip">
            <?=$tooltip;?>
        </div>
    </div>
</div>
<?=$footer;?>
