<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Element extends Composer
{
  protected static $views = [];

  public static function image(int $imageId, $maxWidth, ?string $class = null, ?bool $noLazy = null)
  {
    if (!$imageId) {
      return null;
    }

    $alt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
    $imageType = get_post_mime_type($imageId);

    // Get image metadata for width and height
    $meta = wp_get_attachment_metadata($imageId);
    $width = $meta['width'] ?? 150;
    $height = $meta['height'] ?? 150;

    if ($imageType === 'image/svg+xml') {
      $svgUrl = wp_get_attachment_image_url($imageId);
      $svg = file_get_contents($svgUrl);

      return [
        'type' => 'svg',
        'class' => $class,
        'svg'   => $svg,
      ];
    }

    return [
      'type' => 'image',
      'url'  => wp_get_attachment_image_url($imageId, 'hd'),
      'url-low-quality' => wp_get_attachment_image_url($imageId, 'thumbnail'),
      'srcset' => [
        '240w'  => wp_get_attachment_image_url($imageId, 'xs'),
        '480w'  => wp_get_attachment_image_url($imageId, 'sm'),
        '768w'  => wp_get_attachment_image_url($imageId, 'md'),
        '1024w' => wp_get_attachment_image_url($imageId, 'lg'),
        '1200w' => wp_get_attachment_image_url($imageId, 'xl'),
        '1400w' => wp_get_attachment_image_url($imageId, 'xxl'),
        '1600w' => wp_get_attachment_image_url($imageId, 'xxxl')
      ],
      'alt' => $alt ?: 'image',
      'max-width' => $maxWidth,
      'class' => $class,
      'no-lazy' => $noLazy,
      'width' => $width,
      'height' => $height
    ];
  }

  public static function title(array $data)
  {
    return [
      'suptitle' => $data['suptitle'] ?? '',
      'title'    => $data['title'] ?? '',
      'hn'       => $data['hn'] ?? 'h2'
    ];
  }
}
