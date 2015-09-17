<?php

class SermonPlugin_Controller_Admin_Series extends SermonPlugin_Controller_Admin
{
    public static function actionIndex()
    {
        $spTable = new SermonPlugin_Table_Series();
        $spTable->prepare_items();

        echo static::loadView('admin/series/index', array(
            'spTable' => $spTable,
        ));
    }

    public static function actionNew()
    {
        if (SermonPlugin_Input::isPost()) {
            $model = new SermonPlugin_Model_Series(SermonPlugin_Input::param());
            $model->save();
            SermonPlugin_Router::redirectPath('series-index');
        }

        $model = new SermonPlugin_Model_Series();
        echo static::loadView('admin/series/new', array(
            "_form" => static::loadView('admin/series/_form', array(
                    'model' => $model,
                )),
        ));
    }

    public static function actionEdit()
    {
        $model = SermonPlugin_Model_Series::find(SermonPlugin_Input::param('id'));

        if (SermonPlugin_Input::isPost()) {
            $model->setAttributes(SermonPlugin_Input::param());
            $model->save();
            SermonPlugin_Router::redirectPath('series-index');
        }
        echo static::loadView('admin/series/edit', array(
            "_form" => static::loadView('admin/series/_form', array(
                    'model' => $model,
                )),
        ));
    }



    public static function actionDelete()
    {
        $model = SermonPlugin_Model_Series::find(SermonPlugin_Input::param('id'));
        if (!$model) {
            SermonPlugin_Router::throw404();
        }
        $model->delete();
        SermonPlugin_Router::redirectPath('series-index', "&action=index-series");
    }

}