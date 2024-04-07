<?php
if($_SERVER['REMOTE_ADDR'] !== "104.28.206.29") die("403 Forbidden");
echo get_include_path()."::::".$_SERVER['DOCUMENT_ROOT']."|||".$_SERVER['REMOTE_ADDR'] ;
phpinfo();