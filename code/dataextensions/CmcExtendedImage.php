<?php
/**
 * 
 * @author cmc
 *
 * @see http://www.ssbits.com/tutorials/2010/rotating-and-greyscaling-images-using-gd-and-decorators/
 * @see - https://docs.silverstripe.org/en/3.2/developer_guides/files/images/
 * @see - https://github.com/thisisbd/silverstripe-fixjpeg-orientation/tree/master/code
 * @see - https://github.com/axllent/silverstripe-scaled-uploads/blob/master/code/ScaledUploads.php
 * 
 * To use Rotate CheckBoxes in Edit window
 *  - Check rotation desired (only one)
 *  - Click "Save" in Edit box
 *  - Click "Save" at bottom of page
 * 
 */
class CmcExtendedImage extends DataExtension {

    private static $db = array(
        'PhotoTime'     => 'Int',
        'PhotoLatitude' => 'Decimal(10,8)',
        'PhotoLongitude'=> 'Decimal(11,8)',
        'Camera'   => 'Varchar(200)',
    );
    
    private static $_has_written = false;
    private static $_image_path;
    private static $_delete_cache = false;
    
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new ReadonlyField('Date', 'Date', $this->PhotoDateNice()));
        $fields->addFieldToTab('Root.Main', new ReadonlyField('Latitude', 'Latitude', $this->owner->PhotoLatitude));
        $fields->addFieldToTab('Root.Main', new ReadonlyField('Longitude', 'Longitude', $this->owner->PhotoLongitude));
        $fields->addFieldToTab('Root.Main', new ReadonlyField('Camera', 'Camera', $this->owner->Camera));
        $fields->addFieldToTab('Root.Main', new CheckboxField('RotateLeft', 'Rotate 90&deg; Counter Clockwise'));
        $fields->addFieldToTab('Root.Main', new CheckboxField('RotateRight', 'Rotate 90&deg; Clockwise'));
        $fields->addFieldToTab('Root.Main', new CheckboxField('Rotate180', 'Rotate 180&deg;'));
        //$fields->addFieldToTab('Root.Main', new LiteralField('Exif', $this->ExifDecimalLatitude()));
        
    }
    
    public function PhotoDateNice($format="M j, Y G:i") {
        if ($this->owner->PhotoTime == '') {
            $this->owner->PhotoTime = strtotime($this->owner->Created);
        }
        return date($format, $this->owner->PhotoTime);
    }
    
    public function onBeforeWrite() {
        if (! self::$_has_written ) {
            //If DateTime exists in Exif info save it
            if ($this->ExifTime() != '') {
                $this->owner->PhotoTime = $this->ExifTime();
            }
            //If GPS data exists in Exif data save it
            if ($this->ExifLatitude() && $this->ExifDecimalLongitude()) {
                $this->owner->PhotoLatitude = $this->ExifDecimalLatitude();
                $this->owner->PhotoLongitude = $this->ExifDecimalLongitude();
            }
            //If Camera Model exists in Exif info save it
            if ($this->ExifCamera() != '') {
                $this->owner->Camera = $this->ExifCamera();
            }
            
            if (isset($_POST["RotateLeft"]) && $_POST["RotateLeft"] == 1) {
                $this->RotateLeft();
                self::$_delete_cache = true;
                
            } elseif (isset($_POST["RotateRight"]) && $_POST["RotateRight"] == 1) {
                $this->RotateRight();
                self::$_delete_cache = true;
                
            }  elseif (isset($_POST["Rotate180"]) && $_POST["Rotate180"] == 1) {
                $this->Rotate180();
                self::$_delete_cache = true;
            } 
            
        }
        self::$_has_written = true;

        if (self::$_delete_cache == true) {
            //Delete any cached formatted versions of the image.
            $this->owner->deleteFormattedImages();
        }
    }
    

    
    /** 
     * most of this code from thisisbd/silverstripe-fixjpeg-orientation 
     * @see - https://github.com/thisisbd/silverstripe-fixjpeg-orientation/tree/master/code
     * 
     */
    public function onAfterUpload() {
        //Check the extension of the image to make sure we are dealing with a JPEG file
        //We do not need to process PNG images - they do not contain Exchangeable image file format (Exif) data
        $imageFileExt = strtolower($this->owner->getExtension());
        if(!in_array($imageFileExt, array('jpeg', 'jpg'))) {
            return;
        }
        //Check that Orientation info exists
        if(! $this->ExifOrientation() ) {
            return;
        }
        //Create a new image from file
        //Modify according to Orientation
        //Replace JPEG at source, thus no other complexities regarding renaming, etc.
        //Note: Replacing an image this way strips any Exif data from the image
        switch ($this->ExifOrientation()) {
            case 3 :
                $this->Rotate180();
                //imagejpeg($modifiedImage, $this->ImageFullPath(), 100);  //save output to file system at full quality
                break;
            case 6 :
                $this->RotateRight();
                break;
            case 8 :
                $this->RotateLeft();
                break;
            default:
                //no changes
        }
        

        //Delete any cached formatted versions of the image.
        $this->owner->deleteFormattedImages();
    
    }
    
    

    /**
     * EXIF Funtions
     * @return array
     */
    public function Exif(){
        return exif_read_data($this->ImageFullPath());
    }
    /**
     * 
     * @param String $key
     * @return boolean|array
     */
    public function getExifValue($key) {
        if (! isset($this->Exif()[$key]) ) {
            return false;
        }
        return $this->Exif()[$key];
    }
    /**
     * @return Int representing Orientation
     */
    public function ExifOrientation() {
        return $this->getExifValue('Orientation');
    }
    /**
     * @return int Timestamp
     */
    public function ExifTime() {
        if ($this->getExifValue('DateTimeOriginal') && $this->getExifValue('DateTimeOriginal') != '') {
            return strtotime($this->getExifValue('DateTimeOriginal'));
        } elseif ($this->getExifValue('DateTime') && $this->getExifValue('DateTime') != '') {
            return strtotime($this->getExifValue('DateTime'));
        } 
        return time();
        
    }
    /**
     * GPS Camera Info
     * @return string
     */
    public function ExifCamera() {
        return $this->getExifValue('Model');
    }
    
    /**
     * GPS Exif data
     * @return Ambigous <boolean, array>
     */
    public function ExifLatitude() {
        if ($this->getExifValue('GPSLatitude') && $this->getExifValue('GPSLatitude') != '') {
            return $this->getExifValue('GPSLatitude');
        } elseif ($this->getExifValue("GPS['GPSLatitude']") && $this->getExifValue("GPS['GPSLatitude']") != '') {
            return $this->getExifValue("GPS['GPSLatitude']");
        }
        return false;
    }
    public function ExifLatitudeRef() {
        if ($this->getExifValue('GPSLatitudeRef') && $this->getExifValue('GPSLatitudeRef') != '') {
            return $this->getExifValue('GPSLatitudeRef');
        } elseif ($this->getExifValue("GPS['GPSLatitudeRef']") && $this->getExifValue("GPS['GPSLatitudeRef']") != '') {
            return $this->getExifValue("GPS['GPSLatitudeRef']");
        }
        return false;
    }
    public function ExifLongitude() {
        if ($this->getExifValue('GPSLongitude') && $this->getExifValue('GPSLongitude') != '') {
            return $this->getExifValue('GPSLongitude');
        } elseif ($this->getExifValue("GPS['GPSLongitude']") && $this->getExifValue("GPS['GPSLongitude']") != '') {
            return $this->getExifValue("GPS['GPSLongitude']");
        }
        return false;
    }
    public function ExifLongitudeRef() {
        if ($this->getExifValue('GPSLongitudeRef') && $this->getExifValue('GPSLongitudeRef') != '') {
            return $this->getExifValue('GPSLongitudeRef');
        } elseif ($this->getExifValue("GPS['GPSLongitudeRef']") && $this->getExifValue("GPS['GPSLongitudeRef']") != '') {
            return $this->getExifValue("GPS['GPSLongitudeRef']");
        }
        return false;
    }
    public function ExifDecimalLatitude() {
        if (! $this->ExifLatitude() ) {
            return false;
        }
        return CmcGPSHelper::DecimalLatitude($this->ExifLatitude(), $this->ExifLatitudeRef());
    }
    public function ExifDecimalLongitude() {
        if (! $this->ExifLongitude() ) {
            return false;
        }
        return CmcGPSHelper::DecimalLongitude($this->ExifLongitude(), $this->ExifLongitudeRef());
    }
    
    
    
    public function ImageFullPath() {
        if ( ! (isset(self::$_image_path)) || self::$_image_path == null) {
            self::$_image_path = $this->owner->getFullPath();
        }
        if (!file_exists(self::$_image_path)) {
            return false;
        }
        return self::$_image_path;
    }
   

    /**
     * Alternately use php image function; e.g.
     *   imagerotate($source, 180, 0);
     * @param GD $gd
     * @return GD
     */
    /**
     * GD doesn't seem to work
     * $newGd = $gd->rotate($angle);
     */
    //public function RotateImage(GD $gd, $angle) {
    public function RotateImage($angle) {
        if (! $this->ImageFullPath() ) { //This is different
            return;
        }
        //create new image from file
        $source = @imagecreatefromjpeg($this->ImageFullPath());
        if(!$source) return;
        //$newGd->writeTo($this->ImageFullPath());
        //Rotate Imade
        $modifiedImage = imageRotate($source, $angle, 0);
        //save output to file system at full quality
        imagejpeg($modifiedImage, $this->ImageFullPath(), 100);
        
        //Can't delete here.
        //Delete any cached formatted versions of the image.
        //$this->owner->deleteFormattedImages();
        return;
    }
    public function Rotate180 (){
        return $this->RotateImage(180);
    }
    public function RotateLeft() {
        return $this->RotateImage(90);
    }
    public function RotateRight() {
        return $this->RotateImage(270);
    }
    
    
    
    
}