<?php

namespace Azonmedia\Debug\Interfaces;

interface CommandInterface
{
    public function handle(string $command) : ?string ;

    public function can_handle(string $command) : bool;

    public static function handles_commands() : string;

    public static function help() : string;
}