<?php snippet('layouts/default', slots: true); ?>

<?php $modelCount = 0; ?>
<ol>
  <?php
  /** @var \Kirby\Cms\Page $page * */
  foreach ($page->children() as $actor) {
      $modelCount++; ?>
    <li><a href="<?= $actor->url() ?>"><?= $actor->title() ?></a></li><?php
  }
?>
</ol>

<div id="modelCount"><?= $modelCount ?></div>
