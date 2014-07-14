<?=$head;?>
<?=$header;?>
<div id="content" class="cart">
    <h3><?=$cart_title;?></h3>
    <div class="row">
        <?php if($cart_item_list !== false): ?>
        <table id="tooltips" class="table table-striped cart-table">
                <tr>
                    <td><?=$cart_item;?></td>
                    <td><?=$cart_price_count;?></td>
                    <td><?=$cart_item_count;?></td>  
                    <td><span class="Vp">V</span>p</div></td>
                    <td><span class="Vp">V</span>p</div> (total)</td>
                    <td></td>
                </tr>
                <?php foreach ($cart_item_list as $item): ?>
                 <tr>
                    <td rel="item_<?=$item['item']['realm_id'];?>_<?=$item['item']['entry'];?>"> <?=$item['item']['item_name'];?></td>
                    <td><?=$item['price_count'];?></td>
                    <td><?=$item['count'];?></td>
                    <td><?=$item['Vp_start'];?></td>
                    <td><?=$item['Vp'];?></td>
                    <td><a href="/<?=$folder;?>/cart/delet/<?=$item['id'];?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                </tr>
                <?php endforeach; ?>
        </table>
        <div class="cart-total">
            <table class="table table-striped">
                <tr>
                    <td><?=$cart_types;?> <?=$total['count'];?></td>
                </tr>               
                <tr>
                    <td><?=$cart_item_count;?> <?=$count_total?></td>
                </tr>               
                <tr>
                    <td><?=$cart_total;?>  <?=$total['sum'];?> <span class="Vp">V</span>p</td>
                </tr>                          
            </table>
            <?php if($char_list !== false): ?>
            <form class="form-inline" role="form" method="POST">
                <div class="form-group">
                    <select name="char" class="form-control">
                                <option><?=$cart_chars;?></option> 
                                <?php foreach ($char_list as $key => $val): ?>
                                 <option value="<?=$key;?>"><?=$val['char_name'];?></option>
                                <?php endforeach; ?>                         
                    </select>
                </div>
                <button type="submit" name="send_soap" class="btn btn-small btn-primary"><?=$cart_botton;?></button>
            </form>
            <?php else: ?>
               <?=$message_char_null;?>
            <?php endif; ?>
            </div>
        <?php else: ?>
          <?=$message_cart_null;?>
        <?php endif; ?>
        </div>
    </div>
</div>
<?=$footer;?>

