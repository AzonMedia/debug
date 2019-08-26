<?php

namespace Azonmedia\Debug;


use Azonmedia\Debug\Interfaces\BackendInterface;
use Azonmedia\Debug\Interfaces\DebuggerInterface;

class Debugger
implements DebuggerInterface
{

    protected $backends = [];

    public function __construct(BackendInterface $Backend)
    {
        $this->add_backend($Backend);
    }

    public function add_backend(BackendInterface $Backend) : bool
    {
        $ret = FALSE;
        if (!$this->has_backend($Backend)) {
            $this->backends[] = $Backend;
            $ret = TRUE;
        }
        return $ret;
    }

    public function has_backend(BackendInterface $Backend) : bool
    {
        $ret = FALSE;
        foreach ($this->backends as $RegisteredBackend) {
            if (get_class($RegisteredBackend) === get_class($Backend)) {
                $ret = TRUE;
                break;
            }
        }
        return $ret;
    }

    public function handle(string $command) : ?string
    {
        $ret = NULL;
        //the help command is hardcoded and can not be overrden by the registered backends
        if (strtolower($command) === 'help') {
            $ret = $this->help();
        } else {
            foreach ($this->backends as $RegisteredBackend) {
                $ret = $RegisteredBackend->handle($command);
                if (is_string($ret)) {
                    break;
                }
            }
        }

        return $ret;
    }

    private function help() : string
    {
        $ret = '';
        foreach ($this->backends as $RegisteredBackend) {
            $ret .= $RegisteredBackend->help().PHP_EOL;
        }
        $ret .= 'quit - exit the debugger'.PHP_EOL;
        return $ret;
    }
}