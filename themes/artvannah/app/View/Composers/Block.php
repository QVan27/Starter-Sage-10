<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Block extends Composer
{
  /**
   * Cible tous les blocs Blade dans resources/views/blocks/
   */
  protected static $views = [
    'blocks.*',
  ];

  /**
   * Injecter les données selon le bloc affiché
   */
  public function with(): array
  {
    $viewName = $this->view->name();
    $data = get_fields();

    $blockName = str_replace('blocks.', '', $viewName);
    $methodName = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $blockName))));

    if (method_exists($this, $methodName)) {
      return $this->$methodName($data);
    }

    return [
      'fields' => $data,
    ];
  }

  public function hero(array $data): array
  {
    return [
      'image' => Element::image($data['image'], 1920),
      'classicContent' => Component::classicContent($data),
    ];
  }

  public static function flexibleContent(string $fieldName): array
  {
    $fields = get_field($fieldName);
    $components = [];

    if (!$fields) {
      return ['components' => []];
    }

    $index = 0;
    foreach ($fields as $block) {
      $method = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $block['acf_fc_layout']))));

      if (method_exists(Component::class, $method)) {
        $components[$block['acf_fc_layout'] . '_' . $index] = Component::$method($block);
        $components[$block['acf_fc_layout'] . '_' . $index]['name'] = $block['acf_fc_layout'];
      }

      $index++;
    }

    return [
      'components' => $components
    ];
  }

  public function contentImage(array $data): array
  {
    return [
      'image' => Element::image($data['image'], 768),
      'classicContent' => Component::classicContent($data),
    ];
  }
}
