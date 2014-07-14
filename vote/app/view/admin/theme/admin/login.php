<?=$head;?>
<div class="row">
<div class="col-md-5 col-lg-offset-3">
    <div class="login-msg"><?=$message; ?></div>
</div>
    <div class="col-md-8 col-lg-offset-3">
    <div class="login">
    <h4><a href="/<?=$folder;?>/"><span class="glyphicon glyphicon-home"></span></a> Admin Panel</h4>
    <form class="form-inline" role="form" method="POST" autocomplete="off">
        <div class="form-group">
            <input type="text" name="login" class="form-control" id="exampleInputEmail2" placeholder="<?=$input_login;?>">
        </div>
        <div class="form-group">
            <input type="password" name="pass" class="form-control" id="exampleInputPassword2" placeholder="<?=$input_pass;?>">
        </div>       
        <button type="submit" name="send" class="btn btn-primary"><?=$button_text;?></button>
    </form>
       <p>2014 © Vote Shop</p> 
    </div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>
