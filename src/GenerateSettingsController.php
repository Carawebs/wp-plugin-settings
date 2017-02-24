<?php
namespace Carawebs\Settings;

/**
* Control the registration of new settings in in the {$wpdb->prefix}_options table.
*
* This class is an entry point that can be called by the main plugin controller function.
*/
class GenerateSettingsController
{
    /**
     * Reference the path to the config file
     * @param string $optionsPageConfig E.g. 'path/to/config.php'
     */
    public function __construct($optionsPageConfig)
    {
        $this->optionsPageConfig = $optionsPageConfig;
    }

    private function init()
    {
        $optionsPage = new OptionsPageController(
            new Config($this->optionsPageConfig),
            new RegisterSetting(),
            new AddOptionsPage(),
            new RegisterSection(),
            new RegisterFields()
        );
    }
}
