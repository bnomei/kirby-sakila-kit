<?php snippet('layouts/default', slots: true); ?>

<?php
//$films = khulan([
//    'actors[]' => ['$in' => [page('actor/adam-grant')->uuid()->toString()]],
//]);
?>

<blockquote>
  <ul>
    <li><a href="/film">Load all films</a></li>
    <li><a href="/film?actors=1">Load all films and resolve actors for each film</a></li>
    <li><a href="/film?feature=Trailers">Load all films, extract all features as filter and apply one</a></li>
  </ul>
</blockquote>

<?php $modelCount = 0;

$films = khulan()->aggregate([
    [
        '$match' => ['template' => 'film'],
    ],
    [
        '$lookup' => [
            'from' => 'kirby',
            'localField' => 'actors{}',
            'foreignField' => '_id',
            'as' => 'actor_details',
        ],
    ],
    [
        '$project' => [
            '_id' => 1,
            'title' => 1,
            'id' => 1,
            'actor_details.title' => 1,
        ],
    ],
]);

if ($feature = get('feature')) {
    ?>
  <nav>
    <?php $features = [];
    foreach ($films as $film) {
        $features = array_merge($features, explode(',', $film->special_features()->value()));
    }
    $features = array_unique($features);
    sort($features);
    ?>
    <ul class="filter">
      <?php foreach ($features as $feature) {
          $modelCount++;
          ?>
        <li><a href="<?= $page->url().'?feature='.$feature ?>"><?= $feature ?></a></li>
      <?php } ?>
    </ul>
  </nav>
  <?php
  $films = $films->filterBy('special_features', $feature, ',');
} ?>

<ol>
  <?php
foreach ($films as $film) {
    $modelCount++;
    ?>
    <li>
    <a href="<?= url($film['id']) ?>"><?= $film['title'] ?></a><br>
    <?php if (get('actors') && ! empty($film['actor_details'])) { ?>
      <details>
        <summary>Actors</summary>
        <ul>
          <?php foreach ($film['actor_details'] as $actor) {
              $modelCount++;
              ?>
            <li><?= $actor['title'] ?></li><?php
          } ?>
        </ul>
      </details>
      </li><?php } ?>
  <?php } ?>
</ol>

<div id="modelCount"><?= $modelCount ?></div>
