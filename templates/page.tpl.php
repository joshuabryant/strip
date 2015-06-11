<?php
/**
 * @file
 * Custom theme implementation to display a single Drupal page.
 */
?>

<div class="page">
  <header class="header-main">
    <h1 class="sitename">
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
        <?php if ($logo): ?>
        <img src="<?php print $logo; ?>" alt="<?php print t($site_name); ?>" />
        <?php else: ?>
        <?php print $site_name; ?>
        <?php endif; ?>
      </a>
    </h1>

    <?php print render($page['header']); ?>
  </header>

  <nav class="nav-main">
    <?php print render($page['navigation']); ?>
  </nav>

  <div class="systray">
    <?php print $messages; ?>

    <?php if (!empty($tabs['#primary'])): ?>
    <div class="tabswrap">
      <?php print render($tabs); ?>
    </div>
    <?php endif; ?>
  </div>

  <main id="main" class="main" role="main">
    <?php if (empty($node) && $title): ?>
    <?php print render($title_prefix); ?>
    <h1 class="page-title"><?php print $title; ?></h1>
    <?php print render($title_suffix); ?>
    <?php endif; ?>

    <?php print render($page['content']); ?>
  </main>

  <footer class="footer-main">
    <?php print render($page['footer']); ?>
  </footer>
</div>
