<?php
/**
 * Plugin Name: Bulk Edit Questions Category for LearnDash
 * Plugin URI: https://github.com/j2machado/bulk-edit-question-category-for-learndash
 * Description: Bulk edit questions category for LearnDash
 * Version: 1.0.0
 * Author: Obi Juan Dev
 * Author URI: https://obijuan.dev
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: bulk-edit-question-category-for-learndash
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use Bulk_Edit_Questions_Category_For_LearnDash\MainPlugin;

final class Bulk_Edit_Questions_Category_For_LearnDash {
    
    public static function init() {
        self::define_constants();
        self::load_textdomain();
        add_action( 'plugins_loaded', array( __CLASS__, 'on_plugins_loaded' ) );
        add_action( 'init', array( __CLASS__, 'main_plugin_init' ) );
    }

    public static function define_constants() {
        define( 'BULK_EDIT_QUESTIONS_CATEGORY_FOR_LEARNDASH_VERSION', '1.0.0' );
        define( 'BULK_EDIT_QUESTIONS_CATEGORY_FOR_LEARNDASH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'BULK_EDIT_QUESTIONS_CATEGORY_FOR_LEARNDASH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
    }

    public static function load_textdomain() {
        load_plugin_textdomain(
            'bulk-edit-question-category-for-learndash',
            false,
            BULK_EDIT_QUESTIONS_CATEGORY_FOR_LEARNDASH_PLUGIN_DIR . 'languages/'
        );
    }

     /**
     * Runs on plugins loaded
     */
    public static function on_plugins_loaded() {
        if (!class_exists('SFWD_LMS')) {
            add_action('admin_notices', array(__CLASS__, 'learndash_not_active_notice'));
            return;
        }
    }

    /**
     * Display notice if LearnDash is not active
     */
    public static function learndash_not_active_notice() {
        $message = sprintf(
            /* translators: %s is a link to the LearnDash website. */
            __('Bulk Edit Question Category for LearnDash requires LearnDash LMS plugin to be installed and active. You can download %s here.', 'bulk-edit-question-category-for-learndash'),
            '<a href="https://www.learndash.com" target="_blank">LearnDash</a>'
        );
        echo '<div class="error"><p>' . $message . '</p></div>';
    }

    public static function main_plugin_init() {
        MainPlugin::instance();
    }

}

Bulk_Edit_Questions_Category_For_LearnDash::init();


 