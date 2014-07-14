<!DOCTYPE html>
<html lang="en">
  <head>
    <title>404</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        .MessageBox{
            margin: 0 auto;
            width: 60%;
            border: 1px solid #D3D3D3;
            box-shadow: 0 0 5px #C9C9C9;
            position: relative;
            top: 70px;
            border-radius: 5px;
            padding: 20px;
            font-family: monospace;
            background: #fff;
        }
        .MessageBox h4{
            padding: 0;
            margin: 0;
            font-family: sans-serif;
            color: #8D8D8D;
        }
        .MessageBox hr{
            border-color: rgba(180, 180, 180, 0.28);
        }
    </style>
  </head>
  <body>
      <div class="container">
        <div class="MessageBox">
            <h4>404 Not Found</h4>
            <hr>
            The requested URL <?= (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '/' ; ?> was not found on this server. Link <a href="<?= folder(); ?>/">Home</a>
        </div>
      </div>
  </body>
</html>

