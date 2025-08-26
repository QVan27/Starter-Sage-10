<?php

// if (is_admin()) {
//   include "admin/tinymce-insert-li/insert-lorem-ipsum.php";
// }

if (function_exists('acf_add_options_page')) {
  acf_add_options_page();
}

if (function_exists('acf_add_local_field_group')) {
  acf_add_local_field_group([
    'key' => 'options',
    'title' => 'Options pour les développeurs',
    'fields' => [
      [
        'key' => 'debug_tab',
        'label' => 'Debug',
        'name' => '',
        'type' => 'tab',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'placement' => 'left',
        'endpoint' => 0
      ],
      [
        'key' => 'debug',
        'label' => 'Activer le mode debug',
        'name' => 'debug',
        'type' => 'true_false',
        'instructions' => 'Ce mode est réservé aux développeurs. Ne pas toucher.',
        'required' => 0,
        'conditional_logic' => 0,
        'message' => '',
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => ''
      ],
    ],
    'location' => [
      [
        [
          'param' => 'options_page',
          'operator' => '==',
          'value' => 'acf-options',
        ]
      ]
    ]
  ]);
}

require_once dirname(__DIR__) . '/resources/blocs-setup.php';
require_once dirname(__DIR__) . '/resources/sync-acf.php';
require_once dirname(__DIR__) . '/resources/forms.php';

function remove_gutenberg_styles()
{
  wp_dequeue_style('wp-block-library');
}

add_action('wp_enqueue_scripts', 'remove_gutenberg_styles', 100);

/**
 * Display svg function
 */
function display_svg(string $svg, bool $getUrl = false): string
{
  $basePath = get_theme_file_path("resources/assets/images/svg");
  $baseUri  = get_theme_file_uri("resources/assets/images/svg");

  $filePath = "$basePath/$svg.svg";
  $fileUri  = "$baseUri/$svg.svg";

  if ($getUrl) {
    return $fileUri;
  }

  if (file_exists($filePath)) {
    return file_get_contents($filePath);
  }

  throw new Exception("SVG $svg doesn't exist in /resources/assets/images/svg folder", 1);
}

/**
 * Create all image sizes
 */
add_image_size('xs', 240, 0, true);
add_image_size('sm', 480, 0, true);
add_image_size('md', 768, 0, true);
add_image_size('lg', 1024, 0, true);
add_image_size('xl', 1200, 0, true);
add_image_size('xxl', 1400, 0, true);
add_image_size('xxxl', 1600, 0, true);
add_image_size('hd', 1920, 1080, true);

remove_image_size('1536x1536');
remove_image_size('2048x2048');
update_option('medium_large_size_w', '0');

/**
 * Change slug to camel case
 */
function toCamelCase($string)
{
  return preg_replace_callback(
    '/[-_](.)/',
    function ($matches) {
      return strtoupper($matches[1]);
    },
    $string
  );
}

/**
 * Add menu location
 */
function wpb_custom_new_menu()
{
  register_nav_menu('footer_navigation', __('Footer'));
}
add_action('init', 'wpb_custom_new_menu');

function artvannah_enable_gutenberg_post_ids($can_edit, $post)
{
  if (get_option('page_for_posts') === $post->ID) return true;

  return $can_edit;
}

add_filter('use_block_editor_for_post', 'artvannah_enable_gutenberg_post_ids', 10, 2);

/**
 * Remove the subpages or submenu for editor
 */
add_action('admin_menu', function () {
  $user = wp_get_current_user();

  if ($user->roles[0] === 'editor') {
    global $menu, $submenu;

    unset($menu[25]); // Commentaires
    unset($menu[75]); // Outils
    unset($menu[80]); // Réglages
    unset($menu['80.3496']); // ACF
    unset($menu['99.39787']); // Yoast
    unset($menu[100]); // CPT UI

    unset($submenu['themes.php'][6]); // Apparances -> Personnaliser
    unset($submenu['themes.php'][7]); // Apparances -> Widgets
    unset($submenu['themes.php'][5]); // Apparances -> Thèmes
  }
}, 999);

/**
 * Removes WordPress version number from the generator meta tag.
 *
 * @return string An empty string to remove the version number.
 */
function wp_version_remove_version()
{
  return '';
}

add_filter('the_generator', 'wp_version_remove_version');

/**
 * Hooks into 'admin_init' action to:
 * - Redirect from the comments edit page to the admin dashboard.
 * - Remove the recent comments meta box from the dashboard.
 * - Remove support for comments and trackbacks from all post types that support them.
 */
add_action('admin_init', function () {
  global $pagenow;

  if ($pagenow === 'edit-comments.php') {
    wp_safe_redirect(admin_url());
    exit;
  }

  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

  foreach (get_post_types() as $post_type) {
    if (post_type_supports($post_type, 'comments')) {
      remove_post_type_support($post_type, 'comments');
      remove_post_type_support($post_type, 'trackbacks');
    }
  }
});

/**
 * Disables comments and pings site-wide by:
 * - Returning false for 'comments_open' and 'pings_open' filters.
 * - Returning an empty array for 'comments_array' filter.
 */
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);

/**
 * Hooks into 'admin_menu' action to remove the comments page from the admin menu.
 */
add_action('admin_menu', function () {
  remove_menu_page('edit-comments.php');
});

/**
 * Hooks into 'init' action to remove the comments menu from the admin bar if it is showing.
 */
add_action('init', function () {
  if (is_admin_bar_showing()) {
    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
});

/**
 * Hides the admin bar for all users.
 */
add_filter('show_admin_bar', '__return_false');
