<?php

namespace Azonmedia\Debug\Backends\BasicCommands;

use Azonmedia\Debug\Interfaces\CommandInterface;

class GetMemoryUsage
implements CommandInterface
{
    public function handle(string $command) : ?string
    {
        $ret = NULL;
        if ($this->can_handle($command)) {
            $ret =
                'memory_get_usage(): '.memory_get_usage()/(1024*1024).'Mb'.PHP_EOL.
                'memory_get_usage(TRUE): '.memory_get_usage(TRUE)/(1024*1024).'Mb'.PHP_EOL.
                'memory_get_peak_usage(TRUE): '.memory_get_peak_usage()/(1024*1024).'Mb'.PHP_EOL.
                'memory_get_peak_usage(TRUE): '.memory_get_peak_usage(TRUE)/(1024*1024).'Mb';
        }
        return $ret;
    }

    public function can_handle(string $command) : bool
    {
        return $command === 'show memory';
    }

    public static function handles_commands() : string
    {
        return 'show memory';
    }
}