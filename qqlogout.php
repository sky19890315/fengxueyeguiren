<?php
/**
 * Created by PhpStorm.
 * User: sunkeyi
 * Date: 2017/5/21
 * Time: 下午6:23
 */
setcookie('qq_accesstoken','',time()-36000);
setcookie('qq_openid','',time()-36000);
header('Location:index.php');