<?php

namespace App\Builders;

use App\Repos\Order as OrderRepo;
use App\Repos\User as UserRepo;

class RefundList extends Builder
{

    public function handleOrders(array $trades)
    {
        $orders = $this->getOrders($trades);

        foreach ($trades as $key => $trade) {
            $trades[$key]['order'] = $orders[$trade['order_id']] ?? new \stdClass();
        }

        return $trades;
    }

    public function handleUsers(array $refunds)
    {
        $users = $this->getUsers($refunds);

        foreach ($refunds as $key => $refund) {
            $refunds[$key]['owner'] = $users[$refund['owner_id']] ?? new \stdClass();
        }

        return $refunds;
    }

    public function getOrders(array $trades)
    {
        $ids = kg_array_column($trades, 'order_id');

        $orderRepo = new OrderRepo();

        $orders = $orderRepo->findByIds($ids, ['id', 'sn', 'subject', 'amount']);

        $result = [];

        foreach ($orders->toArray() as $order) {
            $result[$order['id']] = $order;
        }

        return $result;
    }

    public function getUsers(array $refunds)
    {
        $ids = kg_array_column($refunds, 'owner_id');

        $userRepo = new UserRepo();

        $users = $userRepo->findByIds($ids, ['id', 'name']);

        $result = [];

        foreach ($users->toArray() as $user) {
            $result[$user['id']] = $user;
        }

        return $result;
    }

}
