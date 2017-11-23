<?php

namespace app\commands;

use app\models\News;
use yii\console\Controller;

class NewsController extends Controller
{
    /**
     * Add a task to share news.
     * 
     * NOTE: For new news tasks are created automatically.
     */
    public function actionAddShareJobs()
    {
        $newsQuery = News::find()
            ->andWhere([
                'status' => News::STATUS_PUBLISHED,
                'published_to_twitter' => false,
            ])
            ->orderBy(['created_at' => SORT_ASC]);
        
        $current = 0;
        /** @var News $news */
        foreach ($newsQuery->each() as $news) {
            $current++;
            $this->stdout("[{$current}] news: id = {$news->id}\n");

            $news->addShareJob();
        }
    }
}
