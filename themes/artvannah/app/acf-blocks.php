<?php

/**
 * Hide unwanted Gutenberg Blocks
 */
function artvannah_allowed_block_types($allowed_block_types, $editor_context)
{
  $acf_blocks = array_column(acf_get_block_types(), 'name');
  $allowed_core_blocks = [
    'core/paragraph',
    'core/heading',
    'core/list',
    'core/image',
    'core/columns'
  ];

  return array_merge($allowed_core_blocks, $acf_blocks);
}

add_filter('allowed_block_types_all', 'artvannah_allowed_block_types', 10, 2);

/**
 * Back-end preview
 */
function artvannah_acf_block_render_callback($block, $content = '', $is_preview = false)
{
  $slug = str_replace('acf/', '', $block['name']);
  $image_url = get_template_directory_uri() . "/resources/assets/images/acf-block/{$slug}.png";
  $image_path = get_theme_file_path("resources/assets/images/acf-block/{$slug}.png");

  if ($is_preview) {
    if (file_exists($image_path)) {
      echo '<img style="object-fit: contain; width: 100%; height: 100%;" src="' . esc_url($image_url) . '">';
    } else {
      echo '<p style="font-size: 30px; font-weight: bold;">Image d\'aperçu non trouvée dans assets/images/acf-block : ' . $slug . '.png</p>';
    }
    return;
  }

  echo view("blocks.{$slug}", ['block' => $block]);
}

add_action('acf/init', function () {
  if (function_exists('acf_register_block')) {
    $dir = new DirectoryIterator(get_theme_file_path("resources/views/blocks"));

    foreach ($dir as $fileinfo) {
      if (!$fileinfo->isDot()) {
        $slug = str_replace('.blade.php', '', $fileinfo->getFilename());
        $file_path = get_theme_file_path("resources/views/blocks/{$slug}.blade.php");
        $file_headers = get_file_data($file_path, [
          'title' => 'Title',
          'description' => 'Description',
          'category' => 'Category',
          'icon' => 'Icon',
          'post-type' => 'Post-type',
          'keywords' => 'Keywords'
        ]);

        if (empty($file_headers['title'])) wp_die(_e('This block needs a title: ' . $file_path));
        if (empty($file_headers['category'])) wp_die(_e('This block needs a category: ' . $file_path));

        $datas = [
          'name' => $slug,
          'title' => $file_headers['title'],
          'description' => $file_headers['description'],
          'category' => $file_headers['category'],
          'icon' => array(
            'background' => '#000',
            'foreground' => '#bda67f',
            'src' => $file_headers['icon'],
          ),
          'keywords' => explode(' ', $file_headers['keywords']),
          'post_types' => explode(' ', $file_headers['post-type']),
          'mode' => 'edit',
          'supports' => array(
            'align' => false,
            'mode' => true,
            'jsx' => false
          ),
          'render_callback'  => 'artvannah_acf_block_render_callback',
          'example' => array(
            'attributes' => array(
              'mode' => 'preview',
              'data' => array(
                'preview_image' => '<img style="object-fit: contain; width: 100%; height: 100%;" src="' . get_template_directory_uri() . '/assets/images/acf-block/' . $slug . '.png">',
              )
            ),
          ),
        ];

        acf_register_block($datas);
      }
    }
  }
});

/**
 * Add a custom block category for Template Blocks
 *
 * @param array $categories Existing block categories.
 * @param WP_Post $post Current post object.
 * @return array Modified block categories.
 */
function template_block_category($categories, $post)
{
  return array_merge($categories, array(array('slug' => 'template-blocks', 'title' => __('Template Blocks', 'template-blocks'))));
}

add_filter('block_categories', 'template_block_category', 10, 2);