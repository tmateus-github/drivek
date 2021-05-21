<?php


namespace App\Repositories\ExternalUserRepository;


use App\Models\ExternalUserModel;
use App\Repositories\Repository;

class ExternalUserRepository extends Repository implements ExternalUserRepositoryInterface
{
    /**
     * @var ExternalUserModel
     */
    protected $model;

    /**
     * ExternalUserRepository constructor.
     * @param ExternalUserModel $model
     */
    public function __construct(ExternalUserModel $model)
    {
        parent::__construct($model);
    }

    /**
     * @param array $data
     * @param array $target
     * @param array $update
     */
    public function upsert(array $data, array $target, array $update = []): void
    {
        $this->model::upsert(
            $data,
            $target,
            $update
        );
    }
}
