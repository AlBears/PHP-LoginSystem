<?php

require_once('includes/init.php');

Auth::getInstance()->logout();

//Redirect
Util::redirect('/index.php');
