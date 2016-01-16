<?php
class CmcXmlWeatherWidget extends DataObject {

    private static $singular_name = 'Weather Widget';
    private static $plural_name = 'Weather Widgets';
    
    private static $_widget_cache_exp_sec = 0;
    //in TEST MODE to REFRESH xml caches, DELETE or rename cache files
    private static $_widget_test_mode = false; //do this to cache XML files for testing
    private static $_xml_cache_prefix = 'test-';
  
    private $_objWsXml; //Weather Station SimpleXml Object
    private $_objWuXml; //Wunderground SimpleXml Object
    
    private static $db = array(
        'WidgetTitle'           => 'Varchar(255)',
        'MaxCallsPerDay'        => 'Int',
        'CachePath'             => 'Varchar(255)',
        'CacheFile'             => 'Varchar(255)',
        'WundergroundApiKey'    => 'Varchar(255)',
        'WundergroundRefKey'    => 'Varchar(255)',
        'WundergroundPwsId'     => 'Varchar(255)',
        'WeatherlinkUser'       => 'Varchar(255)',
        'WeatherlinkPassword'   => 'Varchar(255)',
        'ExternalUrl'           => 'Varchar(255)',
        'ExternalUrlLabel'      => 'Varchar(255)',
    
    );
        
    private static $belongs_to = array(
        'Page'  => 'Page',    
    );
    
    private static $summary_fields = array(
        'WidgetTitle'                     => 'Weather Widget',
    );
    
    private static $default_sort = array(
        'WidgetTitle',
    );
    
    
    private static $display_fields = array(
        'WidgetTitle'  => 'Weather Widget'
    );

    private static $defaults = array(
        'MaxCallsPerDay'        => 300,
        'CachePath'             => '/assets/cacheFiles/',
    );
    
    public function getTitle() {
        return $this->WidgetTitle;
    }
    
    protected function getCacheExpiration() {
        if (self::$_widget_cache_exp_sec > 0) {
            return self::$_widget_cache_exp_sec;
        }
        if ($this->MaxCallsPerDay <= 0) {
            $this->MaxCallsPerDay = self::$defaults['MaxCallsPerDay'];
        }
        self::$_widget_cache_exp_sec = floor((24 * 60 * 60) / $this->MaxCallsPerDay);
        return self::$_widget_cache_exp_sec;
    }
    
    protected function getFullCachePath(){
        $httpPath= substr(BASE_PATH, 0, strpos(BASE_PATH, 'httpdocs')+8);
        
        if ($this->CachePath == '') {
            $this->CachePath = self::$defaults['CachePath'];
            
            //go ahead and return don't need following tests
            return $httpPath.$this->CachePath;
        } 
        if ( substr($this->CachePath, 0, 1) !== '/' ) {
            $this->CachePath = '/'.$this->CachePath;
        }
        if ( substr($this->CachePath, -1) !== '/' ) {
            $this->CachePath = $this->CachePath.'/';
        }
        
        return $httpPath.$this->CachePath;
    }
    
    protected function getWeatherStationUrl() {
        return 'http://www.weatherlink.com/xml.php?user='.$this->WeatherlinkUser.'&pass='.$this->WeatherlinkPassword;
    }
    
    protected function getWundergroundUrl() {
        //$historyDate = date('Ymd', strtotime('- 2 hours')); //Grab date 2 hours earlier
        //Debug::show($historyDate);
        //with history
//         return 'http://api.wunderground.com/api/'.
//                         $this->WundergroundApiKey.
//                         '/forecast/conditions/history_'.
//                         $historyDate.
//                         '/pws:1/q/pws:'.
//                         $this->WundergroundPwsId.'.xml';
        return 'http://api.wunderground.com/api/'.
            $this->WundergroundApiKey.
            '/forecast/conditions/pws:1/q/pws:'.
            $this->WundergroundPwsId.'.xml';
    }
     
                    
    public function WeatherWidgetHtml() {
        
        if ($this->CacheFile == '') {
            return false;
        }
        $cacheFile = $this->getFullCachePath().$this->CacheFile;
        $this->_objWsXmlUrl = $this->getWeatherStationUrl();
        $this->_objWuXmlUrl = $this->getWundergroundUrl();
        
        //Check if Server time and File time are copacetic
        //echo "Server time: ".date('M d, Y H:i', time()). "<br>" ."File time: ".date('M d, Y H:i', filemtime($cacheFile));
            
        if (!file_exists($cacheFile) ||
            (time() - filemtime($cacheFile) >= $this->getCacheExpiration()) ) { //Refresh sticker cache

            //echo "<br>Cache needs refreshing";
            
                if (self::$_widget_test_mode) { //load weather data from cached xml
                    //Use Cached xml for testing other data to reduce WU calls.
                    
                    //echo "<br>Cache test mode - check that cached XML Files exist, create if not";
                    $this->checkXmlCache($this->getFullCachePath().self::$_xml_cache_prefix.'weatherstation.xml',$this->_objWsXmlUrl);
                    $this->checkXmlCache($this->getFullCachePath().self::$_xml_cache_prefix.'wunderground.xml', $this->_objWuXmlUrl);
                    
                    //echo "<br>Cache test mode - load XML objects from cache";
                    $this->_objWsXml = simplexml_load_file($this->getFullCachePath().self::$_xml_cache_prefix.'weatherstation.xml');
                    $this->_objWuXml = simplexml_load_file($this->getFullCachePath().self::$_xml_cache_prefix.'wunderground.xml');
                
                } else { //Not caching xml, just grab new xml from URLs and cache HTML for 
                    //echo "<br>NOT test mode - Grabbing new XML";
                    $this->_objWsXml = simplexml_load_file($this->_objWsXmlUrl);
                    $this->_objWuXml = simplexml_load_file($this->_objWuXmlUrl);
                    //echo "<br>Cache test mode - load XML objects from cache";
                }
                
                //echo "<br>Refresh  HTML Cache";
                $strHtml = $this->StickerHtml($this->_objWsXml, $this->_objWuXml);
                file_put_contents($cacheFile, $strHtml);
                return $strHtml;
        }
        
        //echo "<br>Read HTML Cache<br><br>";
        return file_get_contents($cacheFile);
    }
    
    protected function StickerHtml() {
        $currentTemp = $this->_objWsXml->temp_f; //round($this->_objWsXml->temp_f);
        if ($currentTemp > 50) {
            $feelTemp = $this->_objWsXml->heat_index_f;
        } else {
            $feelTemp = $this->_objWsXml->windchill_f;
        }
        $strWind = 'Calm';
        if ($this->_objWsXml->wind_mph > 0) {
            $strWind = $this->_objWsXml->wind_mph.'mph '.$this->getWindAbbrv($this->_objWsXml->wind_dir);
        }
        $strRain = "-";
        if ($this->_objWsXml->davis_current_observation->rain_rate_in_per_hr > 0) {
            $strRain = $this->_objWsXml->davis_current_observation->rain_rate_in_per_hr.'"/hr';
        }
        $textForecastIndex = 1;
        if (stristr($this->_objWuXml->forecast->txt_forecast->forecastdays->forecastday[$textForecastIndex]->title, 'Night')) {
            $textForecastIndex++;
        }
        // $strPrecipChance = '';
        // if ($this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->pop > 0 ) {
        
        // }
        /**
         *  High: {$this->_objWsXml->davis_current_observation->temp_day_high_f}&deg;F @ {$this->_objWsXml->davis_current_observation->temp_day_high_time}
         *  Low: {$this->_objWsXml->davis_current_observation->temp_day_low_f}&deg;F @ {$this->_objWsXml->davis_current_observation->temp_day_low_time}
         *  <span class="precip">Rain: {$strRain} Total this month: {$this->_objWsXml->davis_current_observation->rain_month_in}"</span>
         *
         *
         <span class="forecast-temps">
         <span class="forecast-high">High: {$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->high->fahrenheit}&deg;F</span>
         <span class="forecast-low">Low: {$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->low->fahrenheit}&deg;F</span>
         </span>
         */
        $strHtml = <<<EOT
        <img class="conditions-icon" src="{$this->_objWuXml->current_observation->icon_url}">
        <div class="conditions-container">
            <span class="conditions-label label">Current Conditions</span>
            <span class="temp-container">
                <span class="current-temp big">{$currentTemp}&deg;F</span>
                <span clsss="feel-temp">Feels like: {$feelTemp}&deg;F</span>
                <span class="condition-text">{$this->_objWuXml->current_observation->weather}</span>
            </span>
            <span class="other-conditions">
                <span class="wind">Wind: $strWind</span>
                <span class="high-wind">Today's high gust: {$this->_objWsXml->davis_current_observation->wind_day_high_mph}mph @{$this->_objWsXml->davis_current_observation->wind_day_high_time}</span>
                <span class="humidity">Humidity: {$this->_objWsXml->relative_humidity}%</span>
                <span class="pressure">Pressure: {$this->_objWsXml->pressure_in}"
                        {$this->_objWsXml->davis_current_observation->pressure_tendency_string}</span>
                <span class="suntimes">Sunrise: {$this->_objWsXml->davis_current_observation->sunrise}
                        Sunset: {$this->_objWsXml->davis_current_observation->sunset}</span>
            </span>
        </div><!-- .conditions-container -->
        <span class="forecast">
            <img  class="forecast-icon" src="{$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->icon_url}">
            <span class="forecast-label label">Tomorrow
                <!-- {$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->date->weekday_short}
                {$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->date->day}
                {$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->date->monthname_short} -->
            </span>
            <span class="forecast-text">
                {$this->_objWuXml->forecast->txt_forecast->forecastdays->forecastday[$textForecastIndex]->fcttext}
                Low&nbsp;{$this->_objWuXml->forecast->simpleforecast->forecastdays->forecastday[1]->low->fahrenheit}F.
            </span>
        </span>
        <span class="weather-links">
            <span class="forecast-link"><a href="{$this->_objWuXml->current_observation->forecast_url}&apiref={$this->WundergroundRefKey}"
                    title="Complete 10-Day Forecast on Weather Underground">10-Day Forecast</a></span>
            | <span class="history-link"><a href="{$this->_objWuXml->current_observation->history_url}&apiref={$this->WundergroundRefKey}"
                    title="History on Weather Underground">History</a></span>
            | <span class="noaa-link"><a href="{$this->ExternalUrl}"
                    title="{$this->ExternalUrlLabel}">{$this->ExternalUrlLabel}</a></span>
        </span>
        <span class="last-weather-update">{$this->_objWsXml->observation_time}</span>
EOT;
            
        return $strHtml;
    }
    
    
    protected function getWindAbbrv($string) {
        switch (strtolower($string)) {
            case 'north' :
                return 'N';
                break;
            case 'northeast' :
                return 'NE';
                break;
            case 'east' :
                return 'E';
                break;
            case 'southeast' :
                return 'SE';
                break;
            case 'south' :
                return 'S';
                break;
            case 'southwest':
                return 'SW';
                break;
            case 'west':
                return 'W';
                break;
            case 'northwest' :
                return 'NW';
                break;
            default :
                return $string;
        }
    }
    
    // Only used for testing
    protected function checkXmlCache($cacheFile, $xmlUrl) {
        //For now, if testing only refresh cache if no cache file  exists
        //|| (time() - filemtime($cacheFile) >= $this->getCacheExpiration())
        if (!file_exists($cacheFile)  ) {
                $strXml = file_get_contents($xmlUrl);
                file_put_contents($cacheFile, $strXml);
        }
    }
    
}

  
