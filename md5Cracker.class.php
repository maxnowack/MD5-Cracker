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
 
    define("MD5CRACKER_HOST",    "md5cracker.org");
    define("MD5CRACKER_URL",    "/hash.php?hash=%HASH%&id=%NUM%");
    define("MD5CRACKER_NUM",    13);
    define("MD5CRACKER_SEP",    "#--#");

    class md5Cracker
    {
        public function crack($hash)
        {
            for($i=1;$i<=MD5CRACKER_NUM;$i++)
            {
                $res = $this->getResult($hash,$i);
                if($res)
                {
                    return $res;
                }
            }
            return false;
        }
        private function getResult($hash,$num)
        {
            $res = $this->getWebsite(str_replace("%NUM%",$num,str_replace("%HASH%",$hash,MD5CRACKER_URL)));
            if($res)
            {
                preg_match("~".MD5CRACKER_SEP."(.*)".MD5CRACKER_SEP."~is", $res, $match);
                if(isset($match[1]) && $match[1]!="" && stripos($match[1], "notfound-")===false)
                {
                    return $match[1];
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        private function getWebsite($url)
        {
            $sock = fsockopen(MD5CRACKER_HOST,80);
            if($sock)
            {
                $header  = "GET ".$url." HTTP/1.1\r\n";
                $header .= "Host: ".MD5CRACKER_HOST."\r\n";
                $header .= "Referer: http://".MD5CRACKER_HOST."/\r\n";
                $header .= "User-Agent: Mozilla/5.0\r\n";
                $header .= "Connection: close\r\n";
                $header .= "\r\n";
                
                //echo $header;
                
                fputs($sock,$header);
                
                $retStr="";
                
                while(!feof($sock))
                {
                    $retStr .= fgets($sock);
                }
                fclose($sock);
                
                return $retStr;
            }
            else
            {
                return false;
            }
        }
    }
?> 
