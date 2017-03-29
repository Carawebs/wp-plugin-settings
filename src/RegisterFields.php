<?php
namespace Carawebs\Settings;

/**
* Control the registration of new settings in in the {$wpdb->prefix}_options table.
*/
class RegisterFields extends Fields
{
    /**
    * Register a setting.
    *
    * @param array  $args The settings array
    * @param string  $pageSlug The options page slug
    * @param string  $optionName
    * @return $this
    */
    public function setArgs(array $fieldArgs, $pageSlug)
    {
        $this->fieldArgs = $fieldArgs;
        $this->pageSlug = $pageSlug;
        return $this;
    }

    public function addFields()
    {
        // This action is getting the callback method ONCE. Dynamically setting the callback
        // therefore won't work to register multiple sections.
        // add_action( 'admin_init', [$this, 'setupFields'] );

        // Let's try with a closure!
        add_action( 'admin_init', function() {
          foreach ($this->fieldArgs as $sectionID => $fieldsArray) {

              foreach ($fieldsArray as $key => $field) {
                  if (! $this->isFieldTypeValid($field)) {
                      return;
                  }
                  $args = [
                      'option' => $field['option_name'] ?? NULL,
                      'type' => $field['type'] ?? NULL,
                      'name' => $field['name'] ?? NULL,
                      'desc' => $field['desc'] ?? NULL,
                      'placeholder' => $field['placeholder'] ?? NULL,
                      'title' => $field['title'] ?? NULL,
                      'multi_options' => $field['multi_options'] ?? NULL
                  ];
                  add_settings_field(
                      $args['name'],
                      $args['title'],
                      [ $this, 'fieldCallback' . ucfirst($args['type']) ],
                      $this->pageSlug,
                      $sectionID,
                      $args
                  );
              }
          }
        });
    }

    /**
     * Check that the type of field is allowed.
     *
     * @param  array  $field The field config
     * @return boolean
     */
    private function isFieldTypeValid($field)
    {
        return true;
    }
}
