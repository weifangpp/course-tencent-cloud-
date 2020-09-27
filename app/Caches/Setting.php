<?php

namespace App\Caches;

use App\Repos\Setting as SettingRepo;

class Setting extends Cache
{

    protected $lifetime = 365 * 86400;

    public function getLifetime()
    {
        return $this->lifetime;
    }

    public function getKey($id = null)
    {
        return "setting:{$id}";
    }

    public function getContent($id = null)
    {
        $settingRepo = new SettingRepo();

        $items = $settingRepo->findAll(['section' => $id]);

        if ($items->count() == 0) {
            return [];
        }

        $result = [];

        foreach ($items as $item) {
            $result[$item->item_key] = $item->item_value;
        }

        return $result;
    }

}
