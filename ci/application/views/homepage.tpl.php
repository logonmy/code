<!DOCTYPE html>
<html>
    <head>
        <title>Bootstrap 101 Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link href="<?php echo $demo_config['site']['static_path'];?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
    </head>
    <body>
        <script src="<?php echo $demo_config['site']['static_path'];?>/js/jquery-1.9.1.min.js"></script>
        <script src="<?php echo $demo_config['site']['static_path'];?>/js/bootstrap.js"></script>

        <!-- Button to trigger model -->
        <!--<a href="#myModal" role="button" class="btn" data-toggle="modal">查看演示实例</a>-->
        <button type="button" data-toggle="modal" data-toggle="modal" data-target="#myModal">Launch modal</button>

        <!-- Model-->
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledy="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h3 id="myModalLabel">Modal header</h3>
            </div>
            <div class="modal-body">
                <p>One fine body...</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
                <button class="btn btn-primary">Save changes</button>
            </div>
        </div>

        <div class="dropdown">
           <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="/page.html">
            Dropdown
            <b class="caret"></b> 
           </a>
           <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                <li><a href="#">action</a></li>
           </ul>
        </div>
    </body>
</html>
<script>
    $('.dropdown-toggle').dropdown();
</script>
