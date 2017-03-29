<?php
namespace Carawebs\Settings;

/**
* Control the creation of an Options page (under the Settings menu).
*
* @see http://wordpress.stackexchange.com/a/127499
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
            $this->pageArguments['unique_page_slug'],               // ! Menu slug !
            [$this, 'outputOptionsPage']                            // Callback to render form
        );

    }

    /**
     * Output the Options page HTML.
     *
     * Conditionally display the field groups by tag. To display fields on
     * different tags, their parent section should have a different option group.
     *
     * @return string HTML output
     */
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
                if (!isset($_GET['tab'])) {
                    reset($this->tabs);
                    $firstTabKey = key($this->tabs);
                    $firstTab = $this->tabs[$firstTabKey];
                    settings_fields( $firstTab ); // Must be the option group defined with `register_setting()`
                    do_settings_sections( $this->pageArguments['unique_page_slug'] );
                } else {
                    foreach ($this->tabs as $tab) {
                        if ( $_GET['tab'] == $tab ) {
                            settings_fields( $tab ); // Must be the option group defined with `register_setting()`
                            do_settings_sections( $this->pageArguments['unique_page_slug'] );
                        }
                    }
                }
                submit_button();
                ?>
            </form>
        </div> <?php
    }

}
