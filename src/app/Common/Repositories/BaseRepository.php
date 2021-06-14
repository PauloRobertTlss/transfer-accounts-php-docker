<?php declare(strict_types=1);

namespace App\Common\Repositories;

use App\Common\Repositories\Contract\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseRepository
 * @package App\Common\Repositories
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model|null
     */
    protected ?Model $scope = null;

    /**
     * @var string|null
     */
    protected ?string $alias = null;

    /**
     * @return string
     */
    abstract public function model(): string;

    public function __construct()
    {
        $this->boot();
        $this->makeScope();
    }

    public function boot()
    {
    }

    /**
     *
     */
    protected function makeScope(): void
    {
        $this->scope = resolve($this->model());
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes)
    {
        $model = $this->scope->newInstance($attributes);
        $model->save();
        return $model;
    }


}
