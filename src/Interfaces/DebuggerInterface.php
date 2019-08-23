<?php

namespace Azonmedia\Debug\Interfaces;

interface DebuggerInterface
{
    public function handle(string $command) : ?string ;

    public function add_backend(BackendInterface $Backend) : bool;

    public function has_backend(BackendInterface $Backend) : bool;
}