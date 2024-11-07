<?php

namespace App\Services;

class CommandBus
{
    /**
     * Create a new class instance.
     */
    public function dispatch($command)
    {
        $handlerClass = str_replace('Commands', 'Handlers\Commands', get_class($command)) . 'Handler';
        return app($handlerClass)->handle($command);
    }
}
