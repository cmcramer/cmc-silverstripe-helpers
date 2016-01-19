<?php
class CmcGPSHelper {


    public static function DecimalLatitude($coordinate, $hemisphere) {
        return self::DecimalFrom($coordinate, $hemisphere);
    }
    
    public static function DecimalLongitude($coordinate, $hemisphere) {
        return self::DecimalFrom($coordinate, $hemisphere);
    }

    protected static function DecimalFrom($coordinate, $hemisphere) {
        for ($i = 0; $i < 3; $i++) {
            $part = explode('/', $coordinate[$i]);
            if (count($part) == 1) {
                $coordinate[$i] = $part[0];
            } else if (count($part) == 2) {
                $coordinate[$i] = floatval($part[0])/floatval($part[1]);
            } else {
                $coordinate[$i] = 0;
            }
        }
        list($degrees, $minutes, $seconds) = $coordinate;
        $sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
        return $sign * ($degrees + $minutes/60 + $seconds/3600);
    }
}