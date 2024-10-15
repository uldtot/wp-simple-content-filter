<?php
/*
Plugin Name: WP Simple Content Filter
Plugin URI: https://github.com/uldtot/wp-simple-content-filter
Description: A simple plugin to filter content
Version: 1.0
Author: Kim Vinberg
Author URI: https://dicm.dk/
License: Private
*/
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WPSimpleContentFilter
{
    public function __construct()
    {
        // Updates and settings
        require dirname(__FILE__) . "/plugin-update-checker-5.4/plugin-update-checker.php";

        $myUpdateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/uldtot/wp-simple-content-filter/',
            __FILE__, // Full path to the main plugin file or functions.php.
            'wp-simple-content-filter'
        );

        // Set the branch that contains the stable release.
        $myUpdateChecker->setBranch('main');

        // Register shortcode
        add_shortcode('WPSimpleContentFilter', [$this, 'shortcode_callback']);
    }

    // Shortcode callback function
    public function shortcode_callback($atts)
    {
        // Parse shortcode attributes and look for any 'select' attributes
        $parsed_atts = shortcode_atts(
            [
                'showsearch' => 0, // Default: don't show the search field
                'searchinclass' => '', // Class or container for content filtering
            ],
            $atts,
            'WPSimpleContentFilter'
        );

        // Output HTML content
        ob_start();
        ?>

        <div class="wp-simple-content-filter">
            <?php if ($parsed_atts['showsearch'] == 1): ?>
                <!-- Search field -->
                <input type="text" placeholder="Søg..." class="wp-simple-content-filter-search" onkeyup="filterContent()" />
            <?php endif; ?>

            <?php
            // Loop through all attributes and handle any that start with 'select'
            foreach ($atts as $key => $value) {
                if (strpos($key, 'select') === 0 && !empty($value)): ?>
                    <!-- Dropdown -->
                    <select class="wp-simple-content-filter-dropdown" onchange="filterContent()">
                        <?php
                        // Split the comma-separated values for the dropdown
                        $options = explode(',', $value);
                        echo '<option value="">Vælg...</option>';
                        foreach ($options as $option) {
                            echo '<option value="' . esc_attr(trim($option)) . '">' . esc_html(trim($option)) . '</option>';
                        }
                        ?>
                    </select>
                <?php endif;
            }
            ?>

            <!-- Hidden input to pass searchinclass class -->
            <input type="hidden" id="wp-filter-area" value="<?php echo esc_attr($parsed_atts['searchinclass']); ?>" />
        </div>

        <script>
            function filterContent() {
                // Get the search term
                let searchTerm = document.querySelector('.wp-simple-content-filter-search').value.toLowerCase();

                // Get the selected dropdown values
                let selects = document.querySelectorAll('.wp-simple-content-filter-dropdown');
                let selectedValues = Array.from(selects).map(select => select.value.toLowerCase());

                // Get the search area class
                let searchinclassClass = document.getElementById('wp-filter-area').value;
                if (!searchinclassClass) return; // Exit if no search area defined

                // Get all elements within the search area
                let contentItems = document.querySelectorAll('.' + searchinclassClass);

                // Loop through the content items and show/hide based on match
                contentItems.forEach(item => {
                    let itemText = item.textContent.toLowerCase();
                    let matchesSearch = searchTerm === '' || itemText.includes(searchTerm);
                    let matchesSelects = selectedValues.every(value => value === '' || itemText.includes(value));

                    if (matchesSearch && matchesSelects) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        </script>

        <?php
        return ob_get_clean();
    }
}

// Initialize the plugin
$WPSimpleContentFilter = new WPSimpleContentFilter();
