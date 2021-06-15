<?php declare(strict_types=1);

namespace Tests\Traits;

trait TestInstance
{

    abstract public function namespace(): string;

    public function assertInstance(): void
    {
        $onError = false;

        try {
            $class = $this->namespace();
            (new $class(...func_get_args()));
        }catch (\Exception $exception) {
            $onError = true;
        }
        $this->assertFalse($onError);
    }

}
