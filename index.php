<?php
use Frame\Frame;
define('DS',DIRECTORY_SEPARATOR);
define("ROOT_PATH",getcwd().DS);
define('HOME_PATH',ROOT_PATH."Home");

require_once(ROOT_PATH."Frame".DS."Frame.class.php");
Frame::run();
