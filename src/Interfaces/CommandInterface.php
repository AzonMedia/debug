<?php

namespace Azonmedia\Debug\Interfaces;

interface CommandInterface
{
    /**
     * @param string $command The command sent to the debugger
     * @param string $current_prompt The current value of the prompt is passed
     * @param string|null $change_prompt_to Passed by reference. If a value is passed then the prompt of the debugger will be changed to this value
     * @return string|null If NULL is returned it means it can not handle the provided $command
     */
    public function handle(string $command, string $current_prompt, ?string &$change_prompt_to = NULL) : ?string ;

    /**
     * Returns a bool can the passed command be handled by this Command handler
     * @param string $command
     * @return bool
     */
    public function can_handle(string $command) : bool;

    /**
     * A static method giving a list as string of the commands it can handle
     * @return string
     */
    public static function handles_commands() : string;

    /**
     * A static method returning help information
     * @return string
     */
    public static function help() : string;
}