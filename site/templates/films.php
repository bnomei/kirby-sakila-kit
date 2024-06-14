<?php
$objectsCount = 0;
$films = $page->children();

if ($feature = get('feature')) { ?>
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
    <ul>
      <?php foreach ($features as $feature) {
        $objectsCount++;
        ?>
        <li><a href="<?= $page->url() . '?feature=' . $feature ?>"><?= $feature ?></a></li>
      <?php } ?>
    </ul>
  </nav>
  <?php
  // then filter by feature
  $filmIds = lapse([/*$films,*/ $feature], function () use ($films, $feature) {
    return $films->filterBy('special_features', $feature, ',')->map(fn($page) => $page->uuid()->toString())->values();
  }, 15);

  $films = new \Kirby\Cms\Pages($filmIds);
} ?>

<ol>
  <?php
  /** @var \Kirby\Cms\Page $page * */
  foreach ($films as $film) {
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
