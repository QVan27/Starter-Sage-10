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
}
