<?php
/**
 * Created by PhpStorm.
 * User: joeychen
 * Date: 2018/9/18
 * Time: 下午 09:13
 */

namespace App;

use Closure;

class MyOrderModel implements IOrderModel
{
    /**
     * @var IRepository
     */
    private $repository;

    public function __construct(IRepository $repository)
    {
        $this->repository = $repository;
    }

    public function save(MyOrder $order, Closure $insertCallback, Closure $updateCallback)
    {
        if (!$this->repository->isExist($order)) {
            $this->repository->insert($order);
            $insertCallback($order);
        }
        else {
            $this->repository->update($order);
            $updateCallback($order);
        }
    }

    public function delete(Closure $predicate)
    {
        throw new Exception('Not implemented');
    }
}