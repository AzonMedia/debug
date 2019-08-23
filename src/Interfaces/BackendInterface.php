<?php

namespace Azonmedia\Debug\Interfaces;

interface BackendInterface
{
    public function handle(string $command) : ?string ;
}