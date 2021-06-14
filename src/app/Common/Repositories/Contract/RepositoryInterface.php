<?php declare(strict_types=1);

namespace App\Common\Repositories\Contract;

/**
 * Interface RepositoryInterface
 * @package App\Common\Repositories\Contract
 */
interface RepositoryInterface
{
    /**
     * @param array $args
     * @return mixed
     */
    public function create(array $args);
}
