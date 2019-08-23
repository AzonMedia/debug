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
        foreach ($this->backends as $RegisteredBackend) {
            $ret = $RegisteredBackend->handle($command);
            if (is_string($ret)) {
                break;
            }
        }
        return $ret;
    }
}