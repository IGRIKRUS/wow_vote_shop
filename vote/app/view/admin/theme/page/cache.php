<?= $head; ?>
<?= $header; ?>
<h4><?=$cache_title;?></h4>
<div class="row adm-add">
    <div class="col-md-5 col-lg-offset-2">
        <h5><?=$cache_tab;?></h5>
        <table class="table table-striped">
            <tr>
                <td><?=$cache_name;?></td><td><?=$cache_date;?></td><td></td>
            </tr>
            <?php if($cache_list !== false):?>
            <?php foreach ($cache_list as $key => $cache): ?>
            <tr>
                <td><?=$cache['name'];?></td><td><?=$cache['time'];?></td><td><a href="/<?=$folder;?>/admin/Cache/del/<?=$key;?>"><span class="glyphicon glyphicon-remove"></span></a></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td><?=$cache_null;?></td>
            </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
<?= $footer;?>