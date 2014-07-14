<?=$head;?>
<?=$header;?>
<script src="/<?=$folder;?>/app/view/<?=$style;?>/js/chart.js"></script>
<h4><?=$stat_title;?></h4>
<div class="row">
    <div class="col-md-7">
        <canvas id="chart" width="600" height="500"></canvas>
    </div>
    <div class="col-md-5">
        <table id="chartData" class="tab-home">

            <?php if($statistic['votes'] !== false): ?>
            <tr style="color: #fff;">
                <th><?=$stat_site;?></th><th><?=$stat_unit;?></th>
            </tr>
            <?php foreach ($statistic['votes'] as $votes): ?>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_vote;?> (<?=$votes['name'];?>)</td><td><?=$votes['_vote'];?></td>
            </tr>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_vote_sms;?> (<?=$votes['name'];?>)</td><td><?=$votes['_sms'];?></td>
            </tr>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_null;?> (<?=$votes['name'];?>)</td><td><?=$votes['_null'];?></td>
            </tr>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_account;?> (<?=$votes['name'];?>)</td><td><?=$votes['account'];?></td>
            </tr>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_characters;?> (<?=$votes['name'];?>)</td><td><?=$votes['characters'];?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr style="color: #fff;">
                <th><?=$stat_error;?></th>
            </tr>
            <?php endif; ?>
            <tr style="color: #fff;">
                <th><?=$stat_servers;?></th><th><?=$stat_unit;?></th>
            </tr>
             <?php if($statistic['servers'] !== false): ?>
             <?php foreach ($statistic['servers'] as $serv): ?>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_account;?> (<?=$serv['name'];?>)</td><td><?=$serv['account'];?></td>
            </tr>
            <tr style="color: <?=RGBColor();?>">
                <td><?=$stat_characters;?> (<?=$serv['name'];?>)</td><td><?=$serv['characters'];?></td>
            </tr>
             <?php endforeach; ?>
             <?php endif; ?>
            </tr>
        </table>
    </div>
</div>   
<?=$footer;?>
