<?php
/**
* The MainPlugin class.
*
* @package Bulk_Edit_Questions_Category_For_LearnDash
* @author Obi Juan Dev
* @since 1.0.0
*/

namespace Bulk_Edit_Questions_Category_For_LearnDash;

class MainPlugin
{

    /**
     * The one true MainPlugin
     *
     * @var MainPlugin
     */
    private static $instance;

    /**
     * Constructor
     */
    private function __construct()
    {
        add_action('bulk_edit_custom_box', array(__CLASS__, 'add_custom_category_to_bulk_edit'), 10, 2);
        add_action('admin_init', array(__CLASS__, 'handle_bulk_category_update_on_submit'));
        add_action('admin_notices', array(__CLASS__, 'show_category_update_notice'));
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_admin_styles'));
    }

    /**
     * Gets the one true instance of the plugin
     *
     * @return MainPlugin
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // Add custom category dropdown to bulk edit
    public static function add_custom_category_to_bulk_edit($column_name, $post_type)
    {
        if ($column_name === 'proquiz_question_category' && $post_type === 'sfwd-question') {
            // Retrieve custom categories
            $categories = self::get_learndash_question_categories(); // Your function to get the array
?>
            <fieldset class="inline-edit-col-left">
                <div class="inline-edit-group" style="display: flex; align-items: center; gap: 10px;">
                    <label id="bulk-edit-question-category-label" class="max-width:100%!important">
                        <span class="title" style="margin-right: 0px;">Category</span>
                        <select name="custom_category" id="custom_category" style="flex: 1;">
                            <option value="-1">No Change</option>
                            <?php
                            foreach ($categories as $category_id => $category_name) {
                                printf(
                                    '<option value="%d">%s</option>',
                                    esc_attr($category_id),
                                    esc_html($category_name)
                                );
                            }
                            ?>
                        </select>
                </div>
            </fieldset>
<?php
        }
    }



    // Handle bulk category update on form submission
    public static function handle_bulk_category_update_on_submit()
    {
        if (! isset($_REQUEST['bulk_edit']) || ! current_user_can('edit_posts')) {
            return;
        }

        $post_ids = isset($_REQUEST['post']) ? array_map('intval', (array) $_REQUEST['post']) : array();
        if (empty($post_ids) || ! isset($_REQUEST['custom_category'])) {
            return;
        }

        $category_id = intval($_REQUEST['custom_category']);
        if ($category_id > 0) {
            foreach ($post_ids as $post_id) {
                if (current_user_can('edit_post', $post_id)) {
                    self::set_learndash_question_category($post_id, $category_id); // Your function
                }
            }

            // Redirect with success message
            $redirect_url = add_query_arg('category_updated', count($post_ids), wp_get_referer());
            wp_safe_redirect($redirect_url);
            exit;
        }
    }

    // Display admin notice
    public static function show_category_update_notice()
    {
        if (! empty($_GET['category_updated'])) {
            $count = intval($_GET['category_updated']);
            printf(
                '<div class="updated"><p>%s</p></div>',
                sprintf(
                    esc_html(
                        /* translators: %d is number of posts. */
                        _n(
                            '%d question category updated.',
                            '%d question categories updated.',
                            $count,
                            'bulk-edit-question-category-for-learndash'
                        )
                    ),
                    esc_html($count)
                )
            );
        }
    }


    /**
     * Retrieve LearnDash question categories
     *
     * @return array Array of question categories with category ID as key and category name as value
     */
    public static function get_learndash_question_categories()
    {
        // Check if LearnDash is active
        if (!class_exists('SFWD_LMS')) {
            return array();
        }

        // Check if the required class exists
        if (!class_exists('\WpProQuiz_Model_CategoryMapper', false)) {
            require_once LEARNDASH_LMS_PLUGIN_DIR . 'includes/lib/wp-pro-quiz/lib/model/WpProQuiz_Model_CategoryMapper.php';
        }

        $categories = array();

        try {
            $category_mapper = new \WpProQuiz_Model_CategoryMapper();
            $question_categories = $category_mapper->fetchAll();

            if (!empty($question_categories) && is_array($question_categories)) {
                foreach ($question_categories as $question_category) {
                    $category_name = $question_category->getCategoryName();
                    $category_id = $question_category->getCategoryId();

                    if (!empty($category_name)) {
                        $categories[$category_id] = $category_name;
                    }
                }
            }
        } catch (Exception $e) {
            // Log error or handle exception
            error_log('Error retrieving LearnDash question categories: ' . $e->getMessage());
        }

        return $categories;
    }

    /**
     * Set a category for a LearnDash question
     *
     * @param int $question_id The WordPress post ID of the question
     * @param int $category_id The ProQuiz category ID to assign
     * @return bool True on success, false on failure
     */
    public static function set_learndash_question_category($question_id, $category_id)
    {
        // Check if LearnDash is active
        if (!class_exists('SFWD_LMS')) {
            return false;
        }

        // Get the ProQuiz question ID
        $question_pro_id = get_post_meta($question_id, 'question_pro_id', true);
        if (empty($question_pro_id)) {
            return false;
        }

        // Check if the required class exists
        if (!class_exists('\WpProQuiz_Model_QuestionMapper')) {
            require_once LEARNDASH_LMS_PLUGIN_DIR . 'includes/lib/wp-pro-quiz/lib/model/WpProQuiz_Model_QuestionMapper.php';
        }

        try {
            // Get the question model
            $question_mapper = new \WpProQuiz_Model_QuestionMapper();
            $question = $question_mapper->fetch($question_pro_id);

            if ($question && is_a($question, 'WpProQuiz_Model_Question')) {
                // Set the category ID
                $question->setCategoryId($category_id);

                // Save the question
                $question_mapper->save($question);

                return true;
            }
        } catch (Exception $e) {
            error_log('Error setting LearnDash question category: ' . $e->getMessage());
        }

        return false;
    }

    public static function enqueue_admin_styles() {
        wp_enqueue_style('bulk-edit-question-category-for-learndash-styles', BULK_EDIT_QUESTIONS_CATEGORY_FOR_LEARNDASH_PLUGIN_URL. 'assets/css/styles.css');
    }
}
