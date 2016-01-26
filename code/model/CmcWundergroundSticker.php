<?php
class CmcWundergroundSticker extends DataObject {

    private static $singular_name = 'Wunderground Sticker';
    private static $plural_name = 'Wunderground Sticker';
    
    //WidgetUrl
    //http://www.wunderground.com/swf/pws_mini_rf_nc.swf?station=<WundergroundStation>&freq=2.5&units=english&lang=EN
    //NOAA Url
    //http://forecast.weather.gov/MapClick.php?lat=<DecLat>&lon=<DecLong>&unit=0&lg=english&FcstType=graphical
    //NOAA UrlLabel ExtLabel
    //  NOAA Weather Forecast Graph
    private static $db = array(
        'WidgetTitle'           => 'Varchar(255)',
        'WidgetForecastUrl'     => 'Varchar(255)',
        'WidgetForecastUrlText' => 'Varchar(255)',
        'WidgetImageUrl'        => 'Varchar(255)',
        'WidgetImageAlt'        => 'Varchar(255)',
        'ImageWidth'            => 'Int',
        'ImageHeight'           => 'Int',
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
        'ImageWidth'            => 300,
        'ImageHeight'           => 100,
        'WidgetForecastUrlText' => 'Click for weather forecast',
    );
    
    public function getTitle() {
        return $this->WidgetTitle;
    }
        
    
    /**
     * Optional WeatherWidgets
     * 
     * For updated Widgets go to http://www.wunderground.com/ 
     *  and search for <WundergroundStation>
     * 
     * Fahrenheit/MPH
     * <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=<WundergroundStation>"><img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250&weatherstationcount=<WundergroundStation>" width="250" height="150" border="0" alt="Weather Underground PWS <WundergroundStation>" /></a>
     * Celsius/KPH
     * <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=<WundergroundStation>"><img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250_metric&weatherstationcount=<WundergroundStation>" width="250" height="150" border="0" alt="Weather Underground PWS <WundergroundStation>" /></a>
     * Fahrenheit and Celsius
     * <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=<WundergroundStation>"><img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250_both&weatherstationcount=<WundergroundStation>" width="250" height="150" border="0" alt="Weather Underground PWS <WundergroundStation>" /></a>
     * 300x100 with forecast
     * <span style="display: block !important; width: 320px; text-align: center; font-family: sans-serif; font-size: 12px;"><a href="http://www.wunderground.com/cgi-bin/findweather/getForecast?query=zmw:05826.1.99999&bannertypeclick=wu_clean2day" title=" Weather Forecast" target="_blank"><img src="http://weathersticker.wunderground.com/weathersticker/cgi-bin/banner/ban/wxBanner?bannertype=wu_clean2day_cond&pwscode=<WundergroundStation>&ForcedCity=<City>&ForcedState=<ST>&zip=05826&language=EN" alt="Find more about Weather in <City>, <ST>" width="300" /></a><br><a href="http://www.wunderground.com/cgi-bin/findweather/getForecast?query=zmw:05826.1.99999&bannertypeclick=wu_clean2day" title="Get latest Weather Forecast updates" style="font-family: sans-serif; font-size: 12px" target="_blank">Click for weather forecast</a></span>
     * Night them with Sunrise/Sunset
     * <span style='display:block !important; width: 276px; text-align: center; font-family: sans-serif; font-size: 12px;'><a href='http://www.wunderground.com/cgi-bin/findweather/getForecast?query=<City>, <ST>' title='<City>, <ST> Weather Forecast'><img src='http://weathersticker.wunderground.com/weathersticker/sunandmoon/language/english/US/<ST>/<City>.gif' alt='Find more about Weather in' /></a><br><a href='http://www.wunderground.com' title='Get latest Weather Forecast updates' style='font-family: sans-serif; font-size: 12px;'>Click for weather forecast</a></span>
     * 
     * @return HTML string
     * 
     * 
     */
    
    public function WeatherWidgetHtml() {
        
        $strHtml = <<<EOT
        <div id="weather-sticker">
        <span><a href="{$this->WidgetForecastUrl}" title="{$this->WidgetForecastUrlText}" 
            target="_blank"><img src="{$this->WidgetImageUrl}" alt="{$this->WidgetImageAlt}" 
            width="{$this->ImageWidth}" height="{$this->ImageHeight}" /></a><br><a 
            href="{$this->WidgetForecastUrl}" title="{$this->WidgetForecastUrlText}" 
                        target="_blank">{$this->WidgetForecastUrlText}</a></span>
		
		<p class="noaa-url"><a href="{$this->ExternalUrl}"
			  title="{$this->ExternalUrlLabel}">{$this->ExternalUrlLabel}</a></p>
    </div><!-- weather-sticker -->
EOT;
        
        return $strHtml;
    }
    

}