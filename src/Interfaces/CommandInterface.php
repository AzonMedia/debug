<?php

namespace Azonmedia\Debug\Interfaces;

interface CommandInterface
{
    public function handle(string $command, string $current_prompt, ?string &$change_prompt_to = NULL) : ?string ;

    public function can_handle(string $command) : bool;

    public static function handles_commands() : string;

    public static function help() : string;
}