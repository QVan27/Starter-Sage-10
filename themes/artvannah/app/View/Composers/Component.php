<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Component extends Composer
{
  /**
   * Vues associées (vide = utilisable partout)
   */
  protected static $views = [];

  /**
   * Retourne le contenu classique
   */
  public static function classicContent(array $data): array
  {
    return [
      'titles'  => Element::title($data),
      'content' => $data['content'] ?? '',
      'button'  => $data['button'] ?? null,
    ];
  }

  /**
   * Structure flexible classique
   */
  public static function flexibleClassicContent(array $data): array
  {
    return [
      'data' => [
        'classic-content' => self::classicContent($data),
      ]
    ];
  }

  /**
   * Structure flexible média
   */
  public static function flexibleMedia(array $data): array
  {
    return [
      'data' => [
        'media' => $data['media'] ?? null,
        'image' => (!empty($data['image']))
          ? Element::image($data['image'], '50vw', null, true)
          : null,
        'video' => [
          'type'   => (!empty($data['video']))
            ? get_post_mime_type($data['video'])
            : null,
          'video'  => (!empty($data['video']))
            ? wp_get_attachment_url($data['video'])
            : null,
          'poster' => (!empty($data['image']))
            ? Element::image($data['image'], '50vw')
            : null,
        ]
      ]
    ];
  }

  public static function postCard(\WP_Post $post): array
  {
    $post_id = $post->ID;

    return [
      'title'    => get_the_title($post_id),
      'link'     => get_permalink($post_id),
      'excerpt'  => get_the_excerpt($post_id),
      'image'    => Element::image(get_post_thumbnail_id($post_id), '33vw', null, true),
      'date'     => get_the_date('', $post_id),
      'category' => get_the_category($post_id)[0]->name ?? null,
    ];
  }
}
