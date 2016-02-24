<?php

session_verify($_SESSION['username']);

get_header();
get_left_menu();
    echo <<<html
    <div id="page-wrapper">
    <div class="collapse navbar-collapse navbar-ex1-collapse">
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              欢迎登陆 <a class="alert-link" href="http://#.com">{$_SESSION['name']}</a>! .
            </div>
    </div>
    </div>
html;


    echo <<<html
    </body>
</html>
html;
