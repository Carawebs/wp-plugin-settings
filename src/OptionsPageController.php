<?php
namespace Carawebs\Settings;

/**
* Control the registration of new settings in in the {$wpdb->prefix}_options table.
*/
class OptionsPageController extends PageController
{
    /**
    * Create a new Settings\Controller instance
    * @param Config          $config          The configuration object
    * @param RegisterSetting $registerSetting Object that registers settings
    * @param OptionsPage     $optionsPage     Object that sets up options page
    * @param RegisterSection $registerSection Object that registers sections
    * @param RegisterFields  $registerFields  Object that registers fields
    */
    function __construct(
        Config $config,
        RegisterSetting $registerSetting,
        AddOptionsPage $optionsPage,
        RegisterSection $registerSection,
        RegisterFields $registerFields
        )
        {
            $this->config = $config->container;
            $this->registerSetting = $registerSetting;
            $this->registerSection = $registerSection;
            $this->optionsPage = $optionsPage;
            $this->registerFields = $registerFields;
            $this->setup();
        }

        /**
        * Setup the options for this plugin.
        *
        * @return void
        */
        public function setup()
        {
            $this->pageSlug = $this->config['page']['unique_page_slug'];
            $this->registerFields();
            $this->addSections();
            $this->optionsPage->setPageArgs($this->config)->addOptionsPage();
        }

        public function registerFields()
        {
            $fields = [];
            foreach ($this->config['sections'] as $section) {
                foreach ($section['fields'] as $field) {
                    $field['option_name'] = $section['option_name'];
                    $field['option_group'] = $section['option_group'];
                    $fields[$section['id']][] = $field;
                }
            }
            $this->registerFields->setArgs($fields, $this->pageSlug)->addFields();
        }

        /**
        * Controls the registration of sections and fields.
        *
        * Loops through section arguments, which contains an array of field arguments
        * for each section.
        *
        * @param array $sectionArgs Section arguments, including field arguments
        * @param string $pageSlug   The page slug - defined as 'unique_page_slug' in $config['page']
        * @param string $optionName  The registered option name as defined by `register_setting()`
        */
        public function addSections()
        {
            $sectionData = [];
            foreach ($this->config['sections'] as $section) {
                $reg = [
                    'id' => $section['id'],
                    'tab' => $section['tab'],
                    'title' => $section['title'],
                    'option_group' => $section['option_group'],
                    'option_name' => $section['option_name'],
                    'option_args' => $section['option_args'] ?? NULL,
                    'description' => $section['description'] ?? NULL
                ];
                $sectionData[$section['id']] = $reg;
                $this->registerSetting->init($reg);
            }
            $this->registerSection->setSectionArgs($sectionData, $this->pageSlug)->addSection();
        }
    }
