<?php
declare(strict_types=1);

namespace Azonmedia\Debug\Backends;

use Azonmedia\Debug\Interfaces\BackendInterface;
use Azonmedia\Debug\Interfaces\CommandInterface;

abstract class BackendBase
    implements BackendInterface
{
    protected $commands = [];

    /**
     * Loads the available commands from BACKENDNAMECommands
     * @param array $commands_classes Array with debug command  classes
     */
    public function __construct(array $commands_classes)
    {
        foreach ($commands_classes as $class) {
            $this->commands[] = new $class();
        }
    }

    public function handle(string $command, string $current_prompt, ?string &$change_prompt_to = NULL) : ?string
    {
        $ret = NULL;
        foreach ($this->commands as $CommandHandler) {
            $ret = $CommandHandler->handle($command, $current_prompt, $change_prompt_to);
            if (is_string($ret)) {
                break;
            }
        }
        return $ret;
    }

    public function help() : string
    {
        $ret = '';
        foreach ($this->commands as $CommandHandler) {
            $ret .= $CommandHandler::help().PHP_EOL;
        }
        return $ret;
    }
}