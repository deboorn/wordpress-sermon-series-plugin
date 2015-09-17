<?php

class SermonPlugin_Controllers_Series extends SermonPlugin_Controller_Base
{
    public static function actionCurrentSeriesLink($attributes, $html = null)
    {
        list($count, $seriesList) = SermonPlugin_Model_Series::search(array(), 1, 0, 'start_date', 'desc');

        if ($count) {
            $series = current($seriesList);
            echo $html . $attributes['sermonpageurl'] . (strpos($attributes['sermonpageurl'], '?') === false ? "?series=" : "&series=") . $series->id;
            return;
        }

        echo $html;

    }

    public static function actionCurrentSeries($attributes, $html = null)
    {
        list($count, $seriesList) = SermonPlugin_Model_Series::search(array(), 1, 0, 'start_date', 'desc');

        echo static::loadView('series/current', array(
            '_header'    => static::getHeader(),
            'html'       => $html,
            'seriesList' => $seriesList,
            'attributes' => $attributes,
        ));
    }

    public static function actionSeriesJson($attributes)
    {
        $params = array();
        if (($search = SermonPlugin_Input::param('series_search'))) {
            $params['title'] = $search;
        }

        list($count, $seriesList) = SermonPlugin_Model_Series::search($params, (int)$attributes['limit'], 0, 'start_date', 'desc');

        $result = array(
            'result' => true,
            'total'  => $count,
            'error'  => '',
            'items'  => array(),
        );

        $domain = get_site_url();
        $domain = parse_url($domain);
        $domain = "{$domain['scheme']}://{$domain['host']}";

        foreach ($seriesList as $series) {
            $image = strpos($series->image, 'http') === false ? $domain . $series->image : $series->image;
            $item = array(
                'series'  => array(
                    'id'         => $series->id,
                    'title'      => $series->title,
                    'image_name' => $image,
                ),
                'sermons' => array()
            );
            list($count, $sermons) = SermonPlugin_Model_Sermons::search(array('series_id' => $series->id), 200, 0, 'start_date', 'desc');
            foreach ($sermons as $sermon) {
                preg_match('/src="([^"]+)"/', $sermon->video_embed, $match);
                $videoUrl = str_replace('title=0&amp;byline=0&amp;portrait=0&', '', $match[1]);
                $videoUrl = strpos($videoUrl, 'http') === false ? "http://" . $videoUrl : $videoUrl;
                $videoUrl = str_replace(':////', '://', $videoUrl);

                $item['sermons'][] = array(
                    'id'          => $sermon->id,
                    'video'       => $videoUrl,
                    'audio'       => $sermon->audio_url,
                    'date'        => $sermon->sermon_date,
                    'title'       => $sermon->title,
                    'description' => $sermon->description,
                    'link'        => "{$domain}/p/watch-sermon/?series={$series->id}&sermon={$sermon->id}",
                );
            }
            $result['items'][] = $item;
        }
        wp_send_json($result);
    }

    public static function actionIndex($attributes, $html = null)
    {
        $params = array();
        if (($search = SermonPlugin_Input::param('series_search'))) {
            $params['title'] = $search;
        }

        list($count, $seriesList) = SermonPlugin_Model_Series::search($params, (int)$attributes['limit'], 0, 'start_date', 'desc');


        switch ((int)$attributes['columns']) {
            case 3:
                $attributes['columns'] = "col-md-4";
                $attributes['break'] = true;
                break;
            case 1:
                $attributes['columns'] = "col-md-12";
                $attributes['break'] = false;
                break;
            default:
                $attributes['columns'] = "col-md-6";
                $attributes['break'] = false;

        }

        echo static::loadView('series/index', array(
            '_header'    => static::getHeader(),
            'html'       => $html,
            'seriesList' => $seriesList,
            'attributes' => $attributes,
        ));
    }
}
