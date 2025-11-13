<?php

namespace holoo\modules\Bases\Http\Contracts;

interface BaseRepositoryInterface
{
    public function find(int $id);

    public function create(array $data);

    public function delete($id);


    function count($id, $where, $model);

    public function update(array $where, array $data);

    public function all($model = null): mixed;

    public function paginates($pages);

    public function withAndPaginate($where,$model, $pages);

    public function where(array $where);

    public function firstWhereModle(?array $where = null , ?string $model = null);

    public function firstRow();
}
