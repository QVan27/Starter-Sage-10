<?php

// Gravity Forms

/**
 * Populate ACF select field options with Gravity Forms forms
 */
function acf_populate_gf_forms_ids($field)
{
  if (class_exists('GFFormsModel')) {
    $choices = [];

    foreach (\GFFormsModel::get_forms() as $form) {
      $choices[$form->id] = $form->title;
    }

    $field['choices'] = $choices;
  }

  return $field;
}
add_filter('acf/load_field/name=id-form', 'acf_populate_gf_forms_ids');

/**
 * Change Gravity Forms submit button
 */
function input_to_button($button, $form)
{
  $dom = new DOMDocument();
  $dom->loadHTML('<?xml encoding="utf-8" ?>' . $button);
  $input = $dom->getElementsByTagName('input')->item(0);
  $new_button = $dom->createElement('button');

  foreach ($input->attributes as $attribute) {
    if ($attribute->name === 'class') $new_button->setAttribute('class', 'gform_button');
    else $new_button->setAttribute($attribute->name, $attribute->value);
  }

  $new_button->setAttribute('aria-label', 'Form submit button');

  $buttonComponent = \Roots\view('elements/button', [
    'data' => [
      'title' => $input->getAttribute('value'),
      'url' => FALSE,
      'target' => NULL,
    ],
    'is_link' => FALSE
  ])->render();

  $d = new DOMDocument();
  libxml_use_internal_errors(true);
  $d->loadHTML("<html>" . $buttonComponent . "</html>");
  libxml_clear_errors();

  $node = $dom->importNode($d->documentElement->firstChild, true);
  $new_button->appendChild($node);

  return $dom->saveHtml($new_button);
}

add_filter('gform_submit_button', 'input_to_button', 10, 2);

/**
 * Allow editors to access Gravity Forms
 */
function wd_gravity_forms_roles()
{
  $role = get_role('editor');
  $role->add_cap('gform_full_access');
}

add_action('admin_init', 'wd_gravity_forms_roles');

/**
 * Change Gravity Forms validation message
 */
function change_message($message, $form)
{

  return '<div class="gform_submission_error hide_summary">
    <span class="gform-icon gform-icon--close"></span>
    ' . __('Une erreur s’est produite lors de votre envoi. veuillez vérifier les champs ci-dessous.') . '
</div>';
}

add_filter('gform_validation_message', 'change_message', 10, 2);

// Advanced Forms

/**
 * Populate ACF select field options with Advanced Forms forms
 */
function acf_populate_af_forms_ids($field)
{
  if (function_exists('af_get_forms')) {
    $choices = [];
    $forms = af_get_forms();

    foreach ($forms as $form) {
      $choices[$form['key']] = $form['title'];
    }

    $field['choices'] = $choices;
  }

  return $field;
}

add_filter('acf/load_field/name=id-form', 'acf_populate_af_forms_ids');

/**
 * Filter submit button attributes for Advanced Forms
 */
function filter_submit_button_attributes($attributes, $form, $args)
{
  $attributes['class'] .= ' button dark';
  $attributes['aria-label'] = 'Soumettre le formulaire ' . $form['title'];

  return $attributes;
}

add_filter('af/form/button_attributes', 'filter_submit_button_attributes', 10, 3);
