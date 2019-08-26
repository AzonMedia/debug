<?php

namespace Azonmedia\Debug\Backends\BasicCommands;

use Azonmedia\Debug\Interfaces\CommandInterface;

class ChangePrompt
    implements CommandInterface
{
    public function handle(string $command, string $current_prompt, ?string &$change_prompt_to = NULL) : ?string
    {
        $ret = NULL;
        if ($this->can_handle($command)) {
            if (stripos($command, 'set prompt ')===0) {
                $new_prompt_value = str_replace('set prompt ','',$command).' ';
                if (!strlen($new_prompt_value)) {
                    $ret = 'Please provide value for the new prompt like "set prompt #".';
                } else {
                    $ret = 'Prompt changed to "'.$new_prompt_value.'".';
                    $change_prompt_to = $new_prompt_value;
                }
            } elseif (strtolower($command) === 'restore prompt') {
                $ret = 'Prompt restored to previous value.';
                $change_prompt_to = '{RESTORE}';
            } else {
                throw new \RuntimeException(sprintf('The module %s is unable to handle the command %s.', get_class($this), $command));
            }
        }
        return $ret;
    }

    public function can_handle(string $command) : bool
    {
        return stripos($command, 'set prompt ')===0 || strtolower($command) === 'restore prompt';
    }

    public static function handles_commands() : string
    {
        $ret = 'set prompt'.PHP_EOL.'restore prompt';
        return $ret;
    }

    public static function help() : string
    {
        $ret = <<<'HELP'
set prompt - sets the prompt to the provided argument
restore prompt - restores the prompt to its previous value
HELP;
        return $ret;
    }
}