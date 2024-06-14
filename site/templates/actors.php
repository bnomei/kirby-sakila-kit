<ul>
  <?php
  /** @var \Kirby\Cms\Page $page * */
  foreach ($page->children() as $actor) {
    ?>
    <li><a href="<?= $actor->url() ?>"><?= $actor->title() ?></a></li><?php
  }
  ?>
</ul>
