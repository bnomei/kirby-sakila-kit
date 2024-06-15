<?php snippet('layouts/default', slots: true); ?>

<blockquote>
  <ul>
    <li><a href="/film">Load all films</a></li>
    <li><a href="/film?actors=1">Load all films and resolve actors for each film</a></li>
    <li><a href="/film?feature=Trailers">Load all films, extract all features as filter and apply one</a></li>
  </ul>
</blockquote>

<?php $modelCount = 0;

$films = $page->children();
if ($feature = get('feature')) {
    ?>
  <nav>
    <?php
      // get all filterable features
      $features = lapse([/*$films,*/ 'features'], function () use ($films) {
          $features = [];
          foreach ($films as $film) {
              $features = array_values(array_merge($features, explode(',', $film->special_features()->value())));

          }
          $features = array_unique($features);
          sort($features);

          return $features;
      }, 15); ?>
    <ul class="filter">
      <?php foreach ($features as $feature) {
          $modelCount++;
          ?>
        <li><a href="<?= $page->url().'?feature='.$feature ?>"><?= $feature ?></a></li>
      <?php } ?>
    </ul>
  </nav>
  <?php
  // then filter by feature
  $filmIds = lapse([/*$films,*/ $feature], function () use ($films, $feature) {
      return $films->filterBy('special_features', $feature, ',')->map(fn ($page) => $page->uuid()->toString())->values();
  }, 15);

    $films = new \Kirby\Cms\Pages($filmIds);
} ?>

<ol>
  <?php
  /** @var \Kirby\Cms\Page $page * */
  foreach ($films as $film) {
      $modelCount++;
      ?>
    <li>
    <a href="<?= $film->url() ?>"><?= $film->title() ?></a><br>
    <?php if (get('actors') && $film->actors()->isNotEmpty()) { ?>
      <details>
        <summary>Actors</summary>
        <ul>
          <?php foreach ($film->actors()->toPages() as $actor) {
              $modelCount++;
              ?>
            <li><?= $actor->title() ?></li><?php
          } ?>
        </ul>
      </details>
      </li><?php } ?>
  <?php } ?>
</ol>

<div id="modelCount"><?= $modelCount ?></div>
