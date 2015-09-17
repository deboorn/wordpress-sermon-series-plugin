<?php if (!function_exists('add_action')) exit(); ?>

<?php echo $html; ?>

<?php echo $_header; ?>

<section class="sermon-plugin">

    <div class="series-list">
        <?php foreach($seriesList as $series): ?>
            <div style="text-align: center;">
                <a class="img-thumbnail" href="<?php echo $attributes['sermonpageurl'] . (strpos($attributes['sermonpageurl'], '?') === false ? "?series=" : "&series=") . $series->id; ?>">
                    <img src="<?php echo $series->image; ?>" style="width:100%; height:auto;">
                    <p><?php echo $series->title; ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if(count($seriesList) == 0): ?>
        <?php if(SermonPlugin_Input::param('series_search')): ?>
            <p>Sorry no matching series found.</p>
        <?php else: ?>
            <p>Sorry nothing to watch yet. Please add a sermon series in the admin panel.</p>
        <?php endif; ?>
    <?php endif; ?>

</section>

