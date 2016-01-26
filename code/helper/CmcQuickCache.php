<?php
/**
 * Class providing static functions for simple caching of external data
 *  - make sure path where files are written has write access enabled
 *  
 * @author cmc
 *
 */
class CmcQuickCache {

    private static $_cache_base_path = '';
    
    public static function HtmlString($cacheFile, $url, $cacheExpiration, $refreshFunc){
        $cacheFile = self::getHttpdocsPath().$cacheFile;
        
        if (!file_exists($cacheFile) ||
            (time() - filemtime($cacheFile) >= $cacheExpiration) ) {
                $str = $refreshFunc();
                file_put_contents($cacheFile, $str);
                return $str;
        }
        
        return file_get_contents($cacheFile);
        
    }

    /**
     * ContentsOfUrl()
     *  
     * @param string $cacheFile - full file name with path
     * @param string $xmlUrl - full url to feed/xml/html/etc you want to cache
     * @param int $cacheExpiration in seconds
     * 
     * @return contents of URL
     */
    public static function ContentsOfUrl($cacheFile, $url, $cacheExpiration){
        $cacheFile = self::getHttpdocsPath().$cacheFile;
        
        if (!file_exists($cacheFile) ||
            (time() - filemtime($cacheFile) >= $cacheExpiration) ) {
                $str = file_get_contents($url);
                file_put_contents($cacheFile, $str);
                return $str;
        }
        
        return file_get_contents($cacheFile);
    }
    

    protected static function getHttpdocsPath() {
        if (self::$_cache_base_path == '') {
            $basePath = dirname(dirname(__FILE__));
            self::$_cache_base_path = substr($basePath, 0, strpos($basePath, 'httpdocs')+8);
        }
        return self::$_cache_base_path;
    }
}