<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\PaginatedData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    /**
     * BaseRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    /**
     * @param       $id
     * @param array $data
     *
     * @return bool
     */
    public function update($id, array $data)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * @param  array  $conditions
     * @param  array  $data
     *
     * @return bool
     */
    public function updateWhere(array $conditions, array $data)
    {
        return $this->model->where($conditions)->update($data);
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function deleteBy(array $data)
    {
        return $this->model->where($data)->delete();
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param array  $conditions
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return mixed
     */
    public function list(array $conditions = [], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->where($conditions)->orderBy($orderBy, $sortBy)->get();
    }

    /**
     * @param array  $conditions
     * @param int    $page
     * @param int    $perPage
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return mixed
     */
    //We Can use default paginate function without doing this, but it causes performance issue with large data
    public function paginatedList(
        array $conditions = [],
        int $page = 1,
        int $perPage = 15,
        string $orderBy = 'created_at',
        string $sortBy = 'asc',
    ) {
        $query =  $this->model->where($conditions);
        $count = $query->count();
        $result = $query
            ->offset($perPage * ($page - 1))
            ->limit($perPage)
            ->orderBy($orderBy, $sortBy)
            ->get();
        return new PaginatedData($count,$result);
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     * @return mixed
     */
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->get($columns);
    }

    /**
     * @param  $id
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOneOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
    /**
     * @param array $data
     * @return Collection
     */
    public function findBy(array $data)
    {
        return $this->model->where($data)->get();
    }

    /**
     * @param array $data
     * @return int
     */
    public function countBy(array $data)
    {
        return $this->model->where($data)->count();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->model->count();
    }

    public function findByWithRelations(array $data, array $relations = [])
    {
        return $this->model->where($data)->with($relations)->get();
    }

    public function findByWithRelationsPaginated(array $data, array $relations = [], int $page = 0, int $perPage = 20)
    {
        return $this->model->where($data)->with($relations)->forPage($page, $perPage)->get();
    }

    public function findByFieldList(string $field, array $values, array $extra = [], array $with = []): Collection
    {
        $query = $this->model->whereIn($field, $values);
        if (!empty($extra)) {
            $query->where($extra);
        }
        if (!empty($with)) {
            $query->with($with);
        }
        return $query->get();
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function findOneBy(array $data)
    {
        return $this->model->where($data)->first();
    }

    public function findOneByWithRelations(array $data, array $relations = [])
    {
        return $this->model->where($data)->with($relations)->first();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOneByOrFail(array $data)
    {
        return $this->model->where($data)->firstOrFail();
    }

    public function findOneByWithRelationsOrFail(array $data, array $relations = [])
    {
        return $this->model->where($data)->with($relations)->firstOrFail();
    }

    public function updateOrCreate(array $findList, array $dataList = [])
    {
        return $this->model->updateOrCreate($findList, $dataList);
    }

    public function updateBy(array $findList, array $dataList = [])
    {
        return $this->model->where($findList)->update($dataList);
    }

    public function updateByFieldList(array $updateValues, string $whereInField, array $whereInValues, array $extraWhereConditions = [],): int
    {
        $query = $this->model->whereIn($whereInField, $whereInValues);
        if (!empty($extraWhereConditions)) {
            $query->where($extraWhereConditions);
        }
        return $query->update($updateValues);
    }

    public function first()
    {
        return $this->model->first();
    }

    public function firstOrCreate(array $attributes)
    {
        return $this->model->firstOrCreate($attributes);
    }
}
