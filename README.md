#SilverStripe Helpers

This is a collection of DataExtensions and DataObjects and Helpers that are often useful for SilverStripe Projects.

#####Requirements:
- unclecheese/display-logic
- sheadawson/silverstripe-linkable

#####Data Extensions 
(must be added via config.yml, e.g. mysite/_config/config.yml)
- CmcExtendedImage 
  * Adds fields to save DateTime, GPS Location and Camera Model with image if available in EXIF data in uploaded image. 
  * Attempts to autorotate image based on EXIF. 
  * Adds manual rotate options to Image Edit. To use Rotate CheckBoxes in Edit window: 
    1. Check rotation desired (only one) 
    2. Click "Save" in Edit box
    3. Click "Save" at bottom of page
- CmcSiteHeaderImage - Use this to add Site Header Image
- CmcSiteLogo - Use this to add up to 2 Logos to your site that are editable in the CMS. Includes fields for Logo, Title and URL
- CmcShortTitle - Add ShortTitle for your Site editable in the Admin. Useful for smaller screens.
- CmcSiteDescription - Add Description for Site editable in Site Settings.
- CmcSiteSocialUrls - Add Urls for Social Media site to use throughout your site; i.e. in site footer
- CmcSiteTwitterFeed - Add a Twitter Feed to your site
- CmcItemList - Add list with expand/collapse, item thumbnail and anchor menu options
- CmcFaqList - Simplified CmcItemList for FAQ

#####GridField (extends various GridField objects)
- CmcAllGridFieldExportButton (extends GridFieldExportButton) - Can be used to export so GridField CSV Export button exports all rows in your list, not just the current page.
- CmcAllGridFieldPrintButton (extends GridFieldPrintButton) - Use to print all rows in your list from Print button
- CmcGridFieldCheckbox (implements GridField_ColumnProvider) - Add a checkbox column to your GridField.
- CmcSelectGridFieldExportButton (extends GridFieldExportButton) - Add an Export Button that only exports selected rows
- CmcSelectGridFieldPrintButton (extends GridFieldPrintButton) - Add an Print Button that only prints selected rows
	
#####Helpers (call public static functions)
- CmcDateHelper - for formatting dates
- CmcGPSHelper - converts GPS from EXIF to Decimal format
- CmcHtmlTextHelper - various helper functions for chopping HTML strings
- CmcNumberFormat - helper for formatting numbers
- CmcQuickCache - helper for caching data read from third party web services
- CmcStringHelper - functions for cleaning and comparing strings

#####Model (DataObjects)
- CmcExternalLink - DataObject with Title, Description, Url field for saving external links. Used with LinkList
- CmcExternalLinkList - DataObject container for External Links
- CmcWundergroundSticker - Use to add Wunderground Weather Sticker from a weather station
- CmcXmlWeatherWidget - Reads XML data from Davis website for your Davis Weather Station for current conditions. Combines with XML data from Wunderground Weather Station for forecast. Requires Davis account and Wunderground API developer account.
- CmcYouTubeEmbed - YouTube Embed with options editable in CMS. 
- CmcListItem - List item with Image and Link. Image field visibility based on containing list settings
- CmcFaqItem - Simplified list item for FAQ
	
	
##Other Resources
images/ - images for social media icons



##Installation

1) Install via composer (or download and add to your project)
```
"cmcramer/cmc-silverstripe-helpers": "master"
```

2) Run dev/build/?flush=all

3) Add DataExtension as desired to config.yml. Some examples:

- Extend all images on your site 
```
Image:
  extensions:
    - CmcExtendedImage
```

- Add HeaderImage, SiteLogo(s), TwitterFeed, SiteSocialUrls, ShortTitle tabs to your Site Settings
```
SiteConfig:
  extensions:
    - CmcSiteHeader
    - CmcSiteLogo
    - CmcSiteTwitterFeed
    - CmcSiteSocialUrls
    - CmcSiteShortTitle
    - CmcSiteDescription
```

4) Add GridField Components to your GridField Config
```
	public function getCMSFields() {
        $fields = parent::getCMSFields();

		...

        // Create a default configuration for the new GridField, allowing record editing
        $gridFieldConfig = GridFieldConfig_RelationEditor::create();
        
        ...

        //Add Export All button
        $exportButton = new CmcAllGridFieldExportButton();
        $exportButton->setExportColumns(MyDataObject::$export_fields);
        $gridFieldConfig->addComponent($exportButton);
        
        //Add Select export button
        $exportSelectedButton = new CmcSelectGridFieldExportButton();
        $exportSelectedButton->setExportColumns(MyDataObject::$export_fields);
        $gridFieldConfig->addComponent($exportSelectedButton);

        //Add Print All button
        $printButton = new CmcAllGridFieldPrintButton();
        $printButton->setPrintColumns(MyDataObject::$export_fields);
        $gridFieldConfig->addComponent($printButton);

        //Add Print Selected button
        $printSelectedButton = new CmcSelectGridFieldPrintButton();
        $printSelectedButton->setPrintColumns(MyDataObject::$export_fields);
        $gridFieldConfig->addComponent($printSelectedButton);
        
        
        // Create a gridfield 
        $gridField = new GridField(
            'MyHasManyField', // Field name
            'My GridField Title', // Field title
            $this->MyHasManyField(), // Get the items
            $gridFieldConfig
        );
        
        // Create a tab named "TabName" and add our field to it
        $fields->addFieldToTab('Root.TabName', $gridField);

		...
	    return $fields;
	}
```

5) Use Helpers by calling public static functions
```
CmcHtmlTextHelper::HtmlSummary ($strHtml, 300);
CmcNumberFormat::NiceFraction ($decimalValue);
```

6) Add DataObjects to your own Page Classes and Data
```
private static $has_one = array (
    'WeatherWidget' => 'CmcXmlWeatherWidget',
);
```

7) FaqList/ItemList add extension to your page class
```
FaqPage:
  extensions:
    - CmcFaqList
```
####Thanks to SilverStripe and the SilverStripe Community


