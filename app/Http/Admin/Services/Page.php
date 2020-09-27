<?php

namespace App\Http\Admin\Services;

use App\Caches\Page as PageCache;
use App\Library\Paginator\Query as PagerQuery;
use App\Models\Page as PageModel;
use App\Repos\Page as PageRepo;
use App\Validators\Page as PageValidator;

class Page extends Service
{

    public function getPages()
    {
        $pagerQuery = new PagerQuery();

        $params = $pagerQuery->getParams();

        $params['deleted'] = $params['deleted'] ?? 0;

        $sort = $pagerQuery->getSort();
        $page = $pagerQuery->getPage();
        $limit = $pagerQuery->getLimit();

        $pageRepo = new PageRepo();

        return $pageRepo->paginate($params, $sort, $page, $limit);
    }

    public function getPage($id)
    {
        return $this->findOrFail($id);
    }

    public function createPage()
    {
        $post = $this->request->getPost();

        $validator = new PageValidator();

        $data = [];

        $data['title'] = $validator->checkTitle($post['title']);
        $data['content'] = $validator->checkContent($post['content']);
        $data['published'] = $validator->checkPublishStatus($post['published']);

        $page = new PageModel();

        $page->create($data);

        $this->rebuildPageCache($page);

        return $page;
    }

    public function updatePage($id)
    {
        $page = $this->findOrFail($id);

        $post = $this->request->getPost();

        $validator = new PageValidator();

        $data = [];

        if (isset($post['title'])) {
            $data['title'] = $validator->checkTitle($post['title']);
        }

        if (isset($post['content'])) {
            $data['content'] = $validator->checkContent($post['content']);
        }

        if (isset($post['published'])) {
            $data['published'] = $validator->checkPublishStatus($post['published']);
        }

        $page->update($data);

        $this->rebuildPageCache($page);

        return $page;
    }

    public function deletePage($id)
    {
        $page = $this->findOrFail($id);

        $page->deleted = 1;

        $page->update();

        $this->rebuildPageCache($page);

        return $page;
    }

    public function restorePage($id)
    {
        $page = $this->findOrFail($id);

        $page->deleted = 0;

        $page->update();

        $this->rebuildPageCache($page);

        return $page;
    }

    protected function rebuildPageCache(PageModel $help)
    {
        $cache = new PageCache();

        $cache->rebuild($help->id);
    }

    protected function findOrFail($id)
    {
        $validator = new PageValidator();

        return $validator->checkPage($id);
    }

}
