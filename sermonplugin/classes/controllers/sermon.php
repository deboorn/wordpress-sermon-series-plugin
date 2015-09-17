<?php

class SermonPlugin_Controllers_Sermon extends SermonPlugin_Controller_Base
{


    public static function actionWatchSermon()
    {
        // fetch series
        $seriesId = SermonPlugin_Input::param('series');
        if ($seriesId == "current") {
            list($count, $rows) = SermonPlugin_Model_Series::search(array(), 1, 0, 'start_date', 'desc');
            $series = $count ? current($rows) : null;
        } else {
            $series = SermonPlugin_Model_Series::find(SermonPlugin_Input::param('series'));
        }
        if (!$series) {
            SermonPlugin_Router::throw404();
        }


        list($count, $sermons) = SermonPlugin_Model_Sermons::search(array('series_id' => $series->id), 200, 0, 'start_date', 'desc');

        $activeSermon = SermonPlugin_Model_Sermons::find(SermonPlugin_Input::param('sermon'));
        foreach ($sermons as $sermon) {
            if (!$activeSermon || $sermon->id == $activeSermon->id) {
                $activeSermon = $sermon;
                break;
            }
        }

        echo static::loadView('sermon/watch', array(
            '_header'      => static::getHeader(),
            'series'       => $series,
            'activeSermon' => $activeSermon,
            'sermons'      => $sermons,
            'totalSermons' => $count,
        ));
    }
}
