<?php

/*
 * Implements HOOK_html_head_alter()
 */
function strip_html_head_alter(&$head_elements) {
  unset($head_elements['system_meta_generator']);
}


/*
 * Implements HOOK_css_alter()
 */
function strip_css_alter(&$css) {
  $unset = array(
    'modules/system/system.base.css',
    'modules/system/system.menus.css',
    'modules/field/theme/field.css',
    'modules/node/node.css',
  );

  $groups = array();
  foreach($css as $path => $settings) {
    // remove unwanted system CSS
    if (in_array($path, $unset)) {
      unset($css[$path]);
    } else {
      $groups[$settings['group']][$path] = $settings;
    }
  }

  // flatten to single group
  $newcss = array();
  ksort($groups);
  $cnt = 0;
  foreach ($groups as $key => $group) {
    foreach ($group as &$settings) {
      $settings['group'] = 0;
      $settings['weight'] = $cnt;
      $cnt++;
    }
    $newcss = array_merge($newcss, $group);
  }

  $css = $newcss;
}


/*
 * Implements HOOK_js_alter()
 */
function strip_js_alter(&$js) {
  foreach($js as $path => $settings) {
    // move scripts to footer
    if(!in_array($path, array('sites/all/themes/strip/js/vendor/modernizr.min.js'))) {
      $js[$path]['scope'] = 'footer';
    }
  }
}


/*
 * Implements HOOK_form_alter()
 */
function strip_form_alter(&$form, &$form_state, $form_id) {
  switch ($form_id) {
    case 'search_block_form':
      $form['search_block_form']['#attributes']['placeholder'] = t('Search');
      break;
  }
}


/**
 * Implement TEMPLATE_preprocess_block()
 */
function strip_preprocess_block(&$vars) {
  if (!empty($vars['block_html_id'])) {
    $vars['classes_array'][] = $vars['block_html_id'];
  }
}


/**
 * Implement TEMPLATE_preprocess_region()
 */
function strip_preprocess_region(&$vars) {
  $vars['classes_array'] = array($vars['region']);
}


/*
 * Implements TEMPLATE_preprocess_field()
 */
function strip_preprocess_field(&$vars) {
  // Add a less verbose field name class: .field-NAME
  $vars['classes_array'][] = drupal_html_class($vars['element']['#field_name']);
 
  // Use .field-body instead of .body
  if ($vars['element']['#field_name'] == 'body') {
    $vars['classes_array'][] = 'field-body';
  }
 
  // Remove some classes from the wrapper <div>.
  $classes_to_remove = array(
    // 'field',
    'field-label-' . drupal_html_class($vars['element']['#label_display']),
    // 'field-type-' . drupal_html_class($vars['element']['#field_type']),
    'field-name-' . drupal_html_class($vars['element']['#field_name']),
    'body',
    'clearfix',
  );
  $vars['classes_array'] = array_diff($vars['classes_array'], $classes_to_remove);
}


/*
 * Implements THEME_field()
 */
function strip_field($vars) {
  $output = '';

  // render the label (if it's not hidden)
  if (!$vars['label_hidden']) {
    $output .= '<div class="field-label field-label-' . $vars['element']['#label_display'] . '"' . $vars['title_attributes'] . '>' . $vars['label'] . '</div>';
  }

  // only wrap all items if more than one item
  $output .= (count($vars['items']) > 1 ? '<div class="field-items"' . $vars['content_attributes'] . '>' : '');

  // render the items
  foreach ($vars['items'] as $delta => $item) {
    $itemoutput = null;
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');

    switch ($vars['element']['#field_name']) {
      default:
        $itemoutput .= drupal_render($item);
    }

    // only wrap items (and add striping) if more than one item
    if (count($vars['items']) > 1 || !$vars['label_hidden']) {
      $output .= '<div class="' . $classes . '"' . $vars['item_attributes'][$delta] . '>' . $itemoutput . '</div>';
    } else {
      $output .= $itemoutput;
    }
  }
  // close the more-than-one-item wrapper
  $output .= (count($vars['items']) > 1 ? '</div>' : '');

  // render the top-level wrapper
  $output = '<div class="' . $vars['classes'] . '"' . $vars['attributes'] . '>' . $output . '</div>';

  return $output;
}


/*
 * Implements THEME_menu_link()
 */
function strip_menu_link(&$vars) {
  $element = $vars['element'];
  $sub_menu = '';
  if($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }
  
  // ALTER MENUS
  $element['#attributes']['class'][] = 'li-depth-'.$element['#original_link']['depth'];
  $element['#attributes']['class'][] = 'li-mlid-'.$vars['element']['#original_link']['mlid'];
  $element['#localized_options']['attributes']['class'][] = 'depth-'.$element['#original_link']['depth'];

  $output = l($element['#title'], $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}
