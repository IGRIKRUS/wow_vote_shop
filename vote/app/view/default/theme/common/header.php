<div id="Messager">
    <?=$message; ?>
</div>

<div class="logo">
    
</div>
<div id="header">
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">  
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/<?=$folder;?>/home"><span class="glyphicon glyphicon-home"></span></a>
            </div>
            <div class="collapse navbar-collapse"  id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="/"><?=$site; ?></a></li>
                    <li><a href="/forum/"><?=$forum; ?></a></li>
                    <li <?php if(reqest('info') === true) echo 'class="active"'; ?> ><a href="/<?=$folder;?>/info"><?=$info; ?></a></li>                    
                </ul>
                 <?php if($active_user === false): ?> 
                <div class="navbar-right">
                    <form class="navbar-form navbar-left" method="POST" autocomplete="off">
                        <div class="form-group">
                            <input type="text" name="login" class="form-control" placeholder="<?=$input_name;?>">
                            <input type="password" name="pass" class="form-control" placeholder="<?=$input_pass;?>">
                            <?php if($select_servers): ?>
                            <select name="serv" class="form-control">
                                <option><?=$select_serv;?> </option>
                                <?php foreach($select_servers as $key => $val): ?>
                                <option value="<?=$key;?>"><?=$val['name']?></option>
                                <?php endforeach;?>
                            </select>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="send" class="btn btn-primary"><?=$button_text;?></button>
                    </form>
                    </div>
                    <?php else: ?>
                        <?=$Menu_account;?>
                   <?php endif; ?>               
            </div>
        </div>
    </nav>
</div>

