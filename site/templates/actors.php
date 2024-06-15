<?php snippet('layouts/default', slots: true); ?>

<?php $modelCount = 0; ?>
<ul>
  <?php
  /** @var \Kirby\Cms\Page $page * */
  foreach ($page->children() as $actor) {
    $modelCount++; ?>
    <li><a href="<?= $actor->url() ?>"><?= $actor->title() ?></a></li><?php
  }
  ?>
</ul>

<div id="modelCount"><?= $modelCount ?></div>
