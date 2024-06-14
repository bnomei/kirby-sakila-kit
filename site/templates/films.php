<?php $objectsCount = 0; ?>
<ol>
  <?php
  /** @var \Kirby\Cms\Page $page * */
  foreach ($page->children() as $film) {
      $objectsCount++;
      ?>
    <li>
    <a href="<?= $film->url() ?>"><?= $film->title() ?></a><br>
    <?php if (get('actors') && $film->actors()->isNotEmpty()) { ?>
      <details>
        <summary>Actors</summary>
        <ul>
          <?php foreach ($film->actors()->toPages() as $actor) {
              $objectsCount++;
              ?>
            <li><?= $actor->title() ?></li><?php
          } ?>
        </ul>
      </details>
      </li><?php } ?>
  <?php } ?>
</ol>

<h2><?= $objectsCount ?> objects</h2>
