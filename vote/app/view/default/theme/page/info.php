<?=$head;?>
<?=$header;?>
<div id="content" class="info">
     <h3><?=$title_info;?></h3>
     <div class="row">
         <?php if($server_list != ''): ?>
         <?php foreach ($server_list as $val): ?>
         <div class="col-md-3  info-bock">
             <h5><?=$val['name'];?> <i class="vs-icon-<?=$val['icon'];?>" style="display: inline-block;width: 50px;height: 20px;float: right;"></i></h5>
             <p><?=$price_vote;?> <?=$val['vote'];?> <span class="Vp">V</span>p</p>
             <p><?=$price_sms_vote;?> <?=$val['vote_sms'];?> <span class="Vp">V</span>p</p>
             <?php if($val['date'] !== false): ?>
             <p><?=$price_date;?> <?=$val['date'];?></p>
             <?php endif; ?>
         </div>  
         <?php endforeach; ?>        
         <?php else: ?>
         <?=$message_null;?>
         <?php endif; ?>
     </div>
</div>
<?=$footer;?>

