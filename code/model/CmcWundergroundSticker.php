<?php
class CmcWundergroundSticker extends DataObject {

    private static $singular_name = 'Wunderground Sticker';
    private static $plural_name = 'Wunderground Sticker';
    
    //WidgetUrl
    //http://www.wunderground.com/swf/pws_mini_rf_nc.swf?station=KVTCRAFT2&freq=2.5&units=english&lang=EN
    //NOAA Url
    //http://forecast.weather.gov/MapClick.php?lat=44.66763&lon=-72.3621784&unit=0&lg=english&FcstType=graphical
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
     *  and search for KVTCRAFT2
     * 
     * Fahrenheit/MPH
     * <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KVTCRAFT2"><img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250&weatherstationcount=KVTCRAFT2" width="250" height="150" border="0" alt="Weather Underground PWS KVTCRAFT2" /></a>
     * Celsius/KPH
     * <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KVTCRAFT2"><img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250_metric&weatherstationcount=KVTCRAFT2" width="250" height="150" border="0" alt="Weather Underground PWS KVTCRAFT2" /></a>
     * Fahrenheit and Celsius
     * <a href="http://www.wunderground.com/weatherstation/WXDailyHistory.asp?ID=KVTCRAFT2"><img src="http://banners.wunderground.com/cgi-bin/banner/ban/wxBanner?bannertype=pws250_both&weatherstationcount=KVTCRAFT2" width="250" height="150" border="0" alt="Weather Underground PWS KVTCRAFT2" /></a>
     * 300x100 with forecast
     * <span style="display: block !important; width: 320px; text-align: center; font-family: sans-serif; font-size: 12px;"><a href="http://www.wunderground.com/cgi-bin/findweather/getForecast?query=zmw:05826.1.99999&bannertypeclick=wu_clean2day" title="Craftsbury, Vermont Weather Forecast" target="_blank"><img src="http://weathersticker.wunderground.com/weathersticker/cgi-bin/banner/ban/wxBanner?bannertype=wu_clean2day_cond&pwscode=KVTCRAFT2&ForcedCity=Craftsbury&ForcedState=VT&zip=05826&language=EN" alt="Find more about Weather in Craftsbury, VT" width="300" /></a><br><a href="http://www.wunderground.com/cgi-bin/findweather/getForecast?query=zmw:05826.1.99999&bannertypeclick=wu_clean2day" title="Get latest Weather Forecast updates" style="font-family: sans-serif; font-size: 12px" target="_blank">Click for weather forecast</a></span>
     * Night them with Sunrise/Sunset
     * <span style='display:block !important; width: 276px; text-align: center; font-family: sans-serif; font-size: 12px;'><a href='http://www.wunderground.com/cgi-bin/findweather/getForecast?query=Craftsbury, VT' title='Craftsbury, VT Weather Forecast'><img src='http://weathersticker.wunderground.com/weathersticker/sunandmoon/language/english/US/VT/Craftsbury.gif' alt='Find more about Weather in Craftsbury, VT' /></a><br><a href='http://www.wunderground.com' title='Get latest Weather Forecast updates' style='font-family: sans-serif; font-size: 12px;'>Click for weather forecast</a></span>
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