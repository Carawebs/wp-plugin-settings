<?php
namespace Carawebs\Settings;

/**
* Control the creation of an Options page (under the Settings menu).
*/
class AddOptionsPage extends Page
{

    /**
    * Create a new menu item
    */
    public function addOptionsPage() {
        add_action( 'admin_menu', [$this, 'defineOptionsPage']);
    }

    /**
    * Add a sub menu page to the Settings menu.
    * @return void
    */
    public function defineOptionsPage() {

        add_options_page(
            __( $this->pageArguments['page_title'], 'textdomain' ), // Page Title
            __( $this->pageArguments['menu_title'], 'textdomain' ), // Menu Title
            $this->pageArguments['capability'],                     // Capability
            $this->pageArguments['unique_page_slug'],                      // ! Menu slug !
            [$this, 'outputOptionsPage']                            // Callback to render form
        );

    }

    public function outputOptionsPage()
    {
        ?>
        <div class="wrap">
            <h2><?= $this->pageArguments['page_title']; ?></h2>
            <h2 class="nav-tab-wrapper">
                <?php $this->tabLinks($_GET["tab"] ?? NULL); ?>
            </h2>
            <form method="post" action="options.php">
                <?php
                // settings_fields( $this->optionGroup ); // Must be the option group defined with `register_setting()`
                // do_settings_sections( $this->pageArguments['unique_page_slug'] );
                // submit_button();
                // @see http://wordpress.stackexchange.com/a/127499
                ?>
                <?php
                // @NOTE: Conditionally display the field groups by tag. To display
                // fields on differen tags, their parent section should have a different
                // option group.
                //
                // @TODO: Work out how to build this programmatically.
                if( $_GET['tab'] == 'social-media' ) {
                    settings_fields( 'social' );
                    do_settings_sections( $this->pageArguments['unique_page_slug'] );
                } else if( $_GET['tab'] == 'main' ) {
                    settings_fields( 'main' );
                    do_settings_sections( $this->pageArguments['unique_page_slug'] );

                }
                submit_button();
                ?>
            </form>
        </div> <?php
    }

}
