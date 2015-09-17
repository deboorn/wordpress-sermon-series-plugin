<?php
if (!function_exists('add_action')) exit();
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_media();
wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

?>

<form action="<?php echo SermonPlugin_Router::getUri(); ?>" method="POST">
    <table class="form-table">
        <!-- series-title -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Sermon Title <span class="description">(required)</span></label>
            </th>
            <td>
                <input type="text" autocomplete="off"
                       spellcheck="true" id="title" size="30"
                       name="title" placeholder="Enter series title"
                       required="required" value="<?php echo $model->title; ?>">
            </td>
        </tr>
        <!-- /series-title -->
        <!-- series-date -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Sermon Date <span class="description">(required)</span></label>
            </th>
            <td>
                <input type="text" autocomplete="off" id="form_sermon_date" size="30"
                       name="sermon_date" placeholder="Enter Date"
                       required="required" value="<?php echo date_i18n('m/d/Y', $model->sermon_date ? : time()); ?>">
            </td>
        </tr>
        <!-- /series-date -->
        <!-- series-audio-url -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Sermon Audio MP3 <span class="description">(required)</span></label>
            </th>
            <td>
                <input type="text" name="audio_url" id="form_audio_url" class="regular-text"
                       placeholder="Enter URL to Sermon Audio or Select Upload below"
                       required="required" value="<?php echo $model->audio_url; ?>" autocomplete="off">

                <input type="button" name="upload-btn" id="upload-btn" class="button-secondary"
                       value="Upload Audio File" style="margin-top: 10px;">

                <div id="audio-preview" style="margin-top:3px;">
                    <audio controls src="<?php echo $model->audio_url; ?>"/>
                </div>

            </td>
        </tr>
        <!-- /series-audio-url -->

        <!-- video-embed-url -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Sermon Video Embed <span class="description">(required)</span></label>
            </th>
            <td>
                <textarea name="video_embed" id="form_video_embed"
                          placeholder="Paste video embed code from any video source such as Vimeo, YouTube, etc."
                          autocomplete="off"
                    ><?php echo $model->video_embed; ?></textarea>

                <div id="video-preview" style="margin-top:3px;"><?php echo $model->video_embed; ?></div>
            </td>
        </tr>
        <!-- /video-embed-url -->

        <!-- video-embed-url -->
        <tr class="form-field form-required">
            <th scope="row">
                <label>Sermon Notes/Description</label>
            </th>
            <td>
                <?php wp_editor($model->description, 'form_description', array(
                    'textarea_rows' => 5,
                    'textarea_name' => 'description',
                )); ?>
            </td>
        </tr>
        <!-- /video-embed-url -->


    </table>

    <div class="submit">
        <button class="button button-primary button-large"
                type="submit"><?php echo $model->id ? "Save" : "Create New"; ?> Sermon
        </button>
    </div>

</form>

<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $("#form_sermon_date").datepicker();

        $('#upload-btn').click(function (e) {
            e.preventDefault();
            var media = wp.media({
                title: 'Upload Sermon Audio Media (MP3)',
                multiple: false
            }).open()
                .on('select', function (e) {
                    var item = media.state().get('selection').first().toJSON();
                    $('#form_audio_url').val(item.url);
                    //$("#audio-preview audio").attr('src', item.url);
                });
        });

        $("#form_audio_url").change(function () {
            $("#audio-preview audio").attr('src', $(this).val());
        });

        $("#form_video_embed").change(function () {
            $("#video-preview").html($(this).val());
        });
    });
</script>


