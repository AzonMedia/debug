<?php
declare(strict_types=1);

namespace Azonmedia\Debug\Interfaces;

interface DebuggerInterface
{
    public function handle(string $command, string $current_prompt, ?string &$change_prompt_to = NULL) : ?string ;

    public function add_backend(BackendInterface $Backend) : bool;

    public function has_backend(BackendInterface $Backend) : bool;
}