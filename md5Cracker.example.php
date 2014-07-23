 <?php
/*******************************************
 * Author: Max Nowack                      *
 * Website: http://max.unsou.de            *
 * Classname: md5Cracker                   *
 *******************************************
 * Description:                            *
 * The class use the site "md5cracker.org" *
 * to crack the provided md5-hash.         *
 *******************************************/ 
 
    error_reporting(E_ALL);
    require_once("md5Cracker.class.php");
    
    $md5Cracker = new Md5Cracker();
    
    $md5String = md5("123456789");
    $value = $md5Cracker->crack($md5String);
    
    if($value)
    {
        echo $value;
    }
    else
    {
        echo "not found";
    }
?> 
