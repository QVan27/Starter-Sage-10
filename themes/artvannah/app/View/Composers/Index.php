<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Index extends Composer
{
  protected static $views = ['index'];

  public function with(): array
  {
    $taxonomy = 'category';
    $terms = get_terms([
      'taxonomy'   => $taxonomy,
      'hide_empty' => true,
    ]);

    $selected = isset($_GET[$taxonomy]) ? (int) $_GET[$taxonomy] : null;

    $args = [
      'post_type'      => 'post',
      'posts_per_page' => 12,
      'post_status'    => 'publish',
    ];

    if ($selected) {
      $args['tax_query'] = [[
        'taxonomy' => $taxonomy,
        'field'    => 'term_id',
        'terms'    => $selected,
      ]];
    }

    $query = new \WP_Query($args);

    $posts = [];
    foreach ($query->posts as $post) {
      $posts[] = [
        'title'    => get_the_title($post->ID),
        'link'     => get_permalink($post->ID),
        'excerpt'  => get_the_excerpt($post->ID),
        'image'    => Element::image(get_post_thumbnail_id($post->ID), '33vw', null, true),
        'date'     => get_the_date('', $post->ID),
        'category' => get_the_category($post->ID)[0]->name ?? null,
      ];
    }

    wp_reset_postdata();

    return [
      'title'       => get_the_title(get_queried_object_id()),
      'content'     => apply_filters('the_content', get_post_field('post_content', get_queried_object_id())),
      'filters'     => [
        'terms'    => $terms,
        'selected' => $selected,
      ],
      'posts'       => $posts,
      'posts_count' => $query->found_posts,
    ];
  }
}
