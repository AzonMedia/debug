<?php

namespace Azonmedia\Debug\Interfaces;

interface BackendInterface
{
    public function handle(string $command, string $current_prompt, ?string &$change_prompt_to = NULL) : ?string ;

    public function help() : string;
}