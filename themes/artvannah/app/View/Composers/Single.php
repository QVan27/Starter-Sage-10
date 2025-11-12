<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Single extends Composer
{
  /**
   * Vues concernées
   */
  protected static $views = [
    'single',
    'single-*',
    'partials.single-*',
  ];

  /**
   * Injection automatique des données
   */
  public function with(): array
  {
    $post_type = get_post_type();

    // Ex : si c’est un "post" => appelle post()
    if (method_exists($this, $post_type)) {
      return $this->$post_type();
    }

    // Fallback générique
    return $this->default();
  }

  /**
   * Single Post
   */
  public function post(): array
  {
    $post_id = get_the_ID();

    return ['image' => Element::image(get_post_thumbnail_id($post_id), '1920px', null, true)];
  }

  /**
   * Fallback générique si pas de méthode spécifique
   */
  protected function default(): array
  {
    $post_id = get_the_ID();

    return [
      'title'   => get_the_title($post_id),
      'content' => get_the_content(null, false, $post_id),
    ];
  }
}
