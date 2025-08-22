<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;
use WP_Query;

class App extends Composer
{
  protected static $views = [
    'partials.head',
    'layouts.app',
    'partials.header'
  ];

  public function with()
  {
    $options = $this->options();

    return [
      'form_submit_class' => $this->formSubmit(),
      'options' => $options,
      'navigation' => $this->menu(),
      'page_for_posts' => get_option('page_for_posts'),
      'App' => [
        'debug' => $options['debug'],
        'instagram' => $options['instagram'],
      ],
    ];
  }

  public function formSubmit()
  {
    return isset($_REQUEST['gform_submit']) ? 'formsubmit-' . $_REQUEST['gform_submit'] : null;
  }

  public function menu()
  {
    $return = [];
    $menus = ['primary_navigation', 'footer_navigation'];
    $menuLocations = get_nav_menu_locations();

    if ($menuLocations) {
      foreach ($menus as $menu) {
        if (!isset($menuLocations[$menu])) {
          continue;
        }

        $id = $menuLocations[$menu];
        $items = wp_get_nav_menu_items($id);
        $data = [];

        foreach ($items as $item) {
          if ($item->menu_item_parent == 0) {
            $itemArray = [
              'id' => $item->object_id,
              'title' => $item->title,
              'url' => $item->url,
              'target' => $item->target,
              'children' => [],
            ];

            foreach ($items as $subItem) {
              if ((int) $subItem->menu_item_parent === $item->ID) {
                $itemArray['children'][] = [
                  'id' => $subItem->ID,
                  'title' => $subItem->title,
                  'url' => $subItem->url,
                  'target' => $subItem->target,
                ];
              }
            }

            $data[] = $itemArray;
          }
        }

        $return[$menu] = $data;
      }
    }

    return $return;
  }

  public function options()
  {
    $options = get_fields('options');

    return [
      'socials' => $options['socials'],
      'debug' => $options['debug'],
      'instagram' => [
        'clientId' => get_option('clientid'),
        'userId' => get_option('userid'),
        'accessToken' => get_option('accesstoken'),
      ],
    ];
  }

  // Méthodes statiques supplémentaires accessibles manuellement
  public static function getPosts($limit = -1, $post_type = 'post', $exclude = [], $new_args = null)
  {
    $args = [
      'post_type' => $post_type,
      'posts_per_page' => $limit,
      'post__not_in' => $exclude,
    ];

    if ($new_args) {
      $args = array_merge($args, $new_args);
    }

    return new WP_Query($args);
  }

  public static function getMainTaxonomy($post_id, $taxonomy = 'category')
  {
    $terms = get_the_terms($post_id, $taxonomy);
    if (!$terms || is_wp_error($terms)) {
      return null;
    }

    $main = function_exists('yoast_get_primary_term_id')
      ? yoast_get_primary_term_id($taxonomy, $post_id)
      : null;

    return count($terms) > 1 && $main
      ? get_term($main)
      : $terms[0];
  }
}
