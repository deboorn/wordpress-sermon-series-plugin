<?php if (!function_exists('add_action')) exit(); ?>

<?php echo $html; ?>

<?php echo $_header; ?>

<section class="sermon-plugin">
    <form action="">
        <input class="col-md-12 col-sm-12 col-xs-12 col-lg-12" type="text" placeholder="Search for a series" id="form_series_search"
               name="series_search" style="margin-bottom: 20px;"
               value="<?php echo SermonPlugin_Input::param('series_search'); ?>"
            />
    </form>

    <div class="row series-list">
        <?php $count = -1; ?>
        <?php foreach($seriesList as $series): $count++; ?>
            <div class="<?php echo $attributes['columns']; ?>" style="<?php echo $attributes['break'] && $count%3 == 0 ? "clear: both;" : ""; ?>">
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

