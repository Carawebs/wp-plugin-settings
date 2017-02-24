<?php
namespace Carawebs\Settings;

/**
* Control the registration of new settings in in the {$wpdb->prefix}_options table.
*/
class RegisterSetting extends Page
{

    /**
    * Register a setting.
    * @param  array  $args [description]
    * @return [type]       [description]
    */
    public function init(array $args)
    {
        register_setting(
            $args['option_group'],
            $args['option_name'],
            [$this, 'sanitizeCallback']//$args['option_args']
        );
        $this->option_name = $args['option_name'];
    }

    public function sanitizeCallback($input)
    {
        $output = [];
        // Loop through each of the incoming options
        foreach( $input as $key => $value ) {

            // Check to see if the current option has a value. If so, process it.
            if( isset( $input[$key] ) ) {

                // Strip all HTML and PHP tags and properly handle quoted strings
                $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

            }

        }

        // @TODO Check that this is necessary!! See `addOptionsPage`
        array_merge(get_option($this->option_name), $output);

        // Return the array processing any additional functions filtered by this action
        // @TODO check this
        return apply_filters( 'sandbox_theme_validate_input_examples', $output, $input );


    }

}
