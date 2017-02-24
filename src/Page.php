<?php
namespace Carawebs\Settings;

/**
* Control the registration of new settings in in the {$wpdb->prefix}_options table.
*/
abstract class Page
{
    public function sanitizeCallback($value)
    {
        // Get all values and return them so we don't overwrite fields on a different tab
        // See: https://github.com/NateWr/simple-admin-pages/blob/master/classes/AdminPage.class.php #111
        // ---------------------------------------------------------------------
    }

    public function setPageArgs(array $args)
    {
        $this->config = $args;
        $this->pageArguments = $args['page'];
        $this->optionGroup = $args['setting']['option_group'];
        $this->setTabs();
        return $this;
    }

    public function tabCheck($tab)
    {
        if(isset($_GET['tab']) && $_GET['tab'] === preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($tab))){
            return true;
        } else {
            return false;
        }
    }

    public function setTabs()
    {
        $tabs = [];
        foreach ($this->config['sections'] as $section) {
            $value = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($section['tab']) );
            $tabs[$section['tab']] = $value;
        }
        $this->tabs = array_unique($tabs);
    }

    public function tabLinks($currentTab)
    {
        ob_start();
        foreach ($this->tabs as $name => $tabQueryString) {
            $link
            ?>
            <a href="?page=<?= $this->pageArguments['unique_page_slug']; ?>&tab=<?= $tabQueryString; ?>" class="nav-tab<?= $this->activeTab($tabQueryString, $currentTab); ?>"><?= $name; ?></a>
            <?php
        }

        echo ob_get_clean();
    }

    public function activeTab($tabQueryString, $currentTab)
    {
        //var_dump($tabQueryString);
        if( ! isset($currentTab)) return;

        if ($tabQueryString === $currentTab) {
            return ' nav-tab-active';
        } else {
            return;
        }


        {
            if($_GET["tab"] == "header-options")
            {
                $active_tab = "header-options";
            }
            else
            {
                $active_tab = "ads-options";
            }
        }
    }

}
