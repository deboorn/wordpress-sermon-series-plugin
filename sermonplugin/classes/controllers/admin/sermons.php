<?php

class SermonPlugin_Controller_Admin_Sermons extends SermonPlugin_Controller_Admin
{

    public static function actionIndex()
    {
        $series = SermonPlugin_Model_Series::find(SermonPlugin_Input::param('series_id'));
        if (!$series) {
            SermonPlugin_Router::throw404();
        }

        $spTable = new SermonPlugin_Table_Sermons();
        $spTable->prepare_items();

        echo static::loadView('admin/sermons/index', array(
            'spTable' => $spTable,
            'series'  => $series,

        ));
    }

    public static function actionNew()
    {
        $series = SermonPlugin_Model_Series::find(SermonPlugin_Input::param('series_id'));
        if (!$series) {
            SermonPlugin_Router::throw404();
        }

        if (SermonPlugin_Input::isPost()) {
            $params = SermonPlugin_Input::param();
            $params['video_embed'] = SermonPlugin_Input::videoEmbed('video_embed');
            $params['description'] = wp_kses_post($_REQUEST['description']);
            $model = new SermonPlugin_Model_Sermons($params);
            $model->save();
            SermonPlugin_Router::redirectPath('series-index', "&action=index-sermons&series_id={$series->id}");
        }

        $model = new SermonPlugin_Model_Sermons();
        echo static::loadView('admin/sermons/new', array(
            "_form"  => static::loadView('admin/sermons/_form', array(
                    'model'  => $model,
                    'series' => $series,
                )),
            'series' => $series,
        ));
    }

    public static function actionEdit()
    {
        $model = SermonPlugin_Model_Sermons::find(SermonPlugin_Input::param('id'));
        $series = SermonPlugin_Model_Series::find($model->series_id);
        if (!$model || !$series) {
            SermonPlugin_Router::throw404();
        }

        if (SermonPlugin_Input::isPost()) {
            $params = SermonPlugin_Input::param();
            $params['video_embed'] = SermonPlugin_Input::videoEmbed('video_embed');
            $params['description'] = wp_kses_post($_REQUEST['description']);
            $model->setAttributes($params);
            $model->save();
            SermonPlugin_Router::redirectPath('series-index', "&action=index-sermons&series_id={$series->id}");
        }
        echo static::loadView('admin/sermons/edit', array(
            "_form"  => static::loadView('admin/sermons/_form', array(
                    'model'  => $model,
                    'series' => $series,
                )),
            'series' => $series,
        ));
    }

    public static function actionDelete()
    {
        $model = SermonPlugin_Model_Sermons::find(SermonPlugin_Input::param('id'));
        if (!$model) {
            SermonPlugin_Router::throw404();
        }
        $seriesId = $model->series_id;
        $model->delete();

        SermonPlugin_Router::redirectPath('series-index', "&action=index-sermons&series_id={$seriesId}");
    }

}