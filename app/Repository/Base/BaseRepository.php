<?php

namespace App\Repository\Base;

use Illuminate\Database\Eloquent\Model;
use Exception;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * Get model
     * @return string
     */
    public function getModel(): string
    {
        throw new Exception('Method getModel is not override');
    }

    /**
     * Set model
     * @return void
     */
    public function setModel(): void
    {
        $this->model = app()->make($this->getModel());
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
