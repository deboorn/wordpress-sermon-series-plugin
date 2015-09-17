<?php if (!function_exists('add_action')) exit(); ?>
<?php echo $_header; ?>

<section class="sermon-plugin" id="watch-sermon">
    <div class="embed-responsive embed-responsive-16by9">
        <?php echo $activeSermon->video_embed; ?>
    </div>
    <div class="row" style="margin-top:10px;">
        <div class="col-md-6">
            <h3><?php echo $activeSermon->title; ?></h3>
            <div class="small" style="margin:0px 0px 5px 5px;">
                <i class="fa fa-clock-o"></i>
                <?php echo date_i18n(get_option('date_format'), $activeSermon->sermon_date); ?>
            </div>

            <div>
                <a target="_blank" class="btn btn-sm btn-default" href="<?php echo $activeSermon->audio_url; ?>">
                    <i class="fa fa-headphones fa-fw"></i> Sermon Audio
                </a>
                <a target="_blank" class="btn btn-sm btn-default" href="http://bible.com">
                    <i class="fa fa-book fa-fw"></i> Bible
                </a>

                <a target="_blank" class="btn btn-sm btn-default" href="http://twitter.com/home/?status=I'd love to share a message with you: <?php echo $activeSermon->title; ?> <?php echo (strpos(the_permalink(), '?') === false ? "?" : "&") . "series={$activeSermon->id}&sermon={$activeSermon->id}"; ?>#watch-sermon">
                    <i class="fa fa-twitter fa-fw"></i>
                </a>

                <a target="_blank" class="btn btn-sm btn-default" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo (strpos(the_permalink(), '?') === false ? "?" : "&") . "series={$activeSermon->id}&sermon={$activeSermon->id}"; ?>#watch-sermon">
                    <i class="fa fa-facebook fa-fw"></i>
                </a>
            </div>

            <div style="margin-top:10px;">
                <small><?php echo $activeSermon->description; ?></small>
            </div>

        </div>
        <div class="col-md-6">
            <h3>In this series</h3>
            <div class="list-group">
                <?php foreach($sermons as $sermon): ?>
                    <a href="<?php echo (strpos(the_permalink(), '?') === false ? "?" : "&") . "series={$series->id}&sermon={$sermon->id}"; ?>#watch-sermon"
                       class="list-group-item <?php if($sermon->id == $activeSermon->id): ?>active<?php endif; ?>" style="padding:5px;">
                        <div class="pull-left">
                            <small><?php echo $sermon->title; ?></small>
                        </div>
                        <div class="pull-right">
                            <small>
                                <?php if($sermon->id == $activeSermon->id): ?><?php else: ?>Play<?php endif; ?>
                                <i class="fa fa-play-circle-o"></i>
                            </small>
                        </div>
                        <div class="clearfix"></div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("a[href='<?php echo the_permalink(); ?>']").attr('href','#watch-sermon');
    });
</script>

