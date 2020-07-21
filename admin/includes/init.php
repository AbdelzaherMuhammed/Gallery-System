<?php


define('DS' ,  DIRECTORY_SEPARATOR) ? null : define('DS' , DIRECTORY_SEPARATOR);

 define('SITE_ROOT' ,'C:' . DS . 'laragon' . DS . 'www' . DS . 'Gallery');

define('INCLUDES_PATH' ,SITE_ROOT . DS . 'admin' . DS . 'includes') ? null : define('INCLUDES_PATH' , SITE_ROOT . DS . 'admin' . DS . 'includes');
require_once(INCLUDES_PATH.DS.'dbObject.php');
require_once(INCLUDES_PATH.DS.'new_config.php');
require_once(INCLUDES_PATH.DS.'functions.php');
require_once(INCLUDES_PATH.DS.'database.php');
require_once(INCLUDES_PATH.DS.'session.php');
require_once(INCLUDES_PATH.DS.'user.php');
require_once(INCLUDES_PATH.DS.'admin-photo.php');
require_once(INCLUDES_PATH.DS.'comment.php');
require_once(INCLUDES_PATH.DS.'paginate.php');


