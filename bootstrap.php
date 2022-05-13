<?php
require __DIR__ . '/vendor/autoload.php';

if((new AugusToolPHP\DateTool())::validateFormatDate('2022-10-15')){
   echo 'ok';
}else{
   echo 'false';
}
