<?php

namespace App\Services\Logic\Topic;

use App\Models\Topic as TopicModel;
use App\Services\Logic\Service;
use App\Services\Logic\TopicTrait;

class TopicInfo extends Service
{

    use TopicTrait;

    public function handle($id)
    {
        $topic = $this->checkTopic($id);

        return $this->handleTopic($topic);
    }

    protected function handleTopic(TopicModel $topic)
    {
        return [
            'id' => $topic->id,
            'title' => $topic->title,
            'summary' => $topic->summary,
        ];
    }

}
