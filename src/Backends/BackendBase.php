<?php


namespace Azonmedia\Debug\Backends;


use Azonmedia\Debug\Interfaces\BackendInterface;

abstract class BackendBase
    implements BackendInterface
{
    protected $commands = [];

    /**
     * Loads the available commands from BACKENDNAMECommands
     */
    public function __construct()
    {

        //foreach class inheriting this the following lookup needs to be done
        $current_class = get_class($this);
        do {

            $temp_arr = explode('\\',$current_class);
            $class_name = array_pop($temp_arr);
            $RClass = new \ReflectionClass($current_class);
            $class_path = $RClass->getFileName();
            $local_path = dirname($class_path).DIRECTORY_SEPARATOR.$class_name.'Commands'.DIRECTORY_SEPARATOR;
//            if (!file_exists($local_path)) {
//                throw new \RuntimeException(sprintf('There is no directory named "%s". This directory must exist and must contain the commands supported by the debugger backend %s.'),$local_path, get_class($this) );
//            } elseif (!is_dir($local_path)) {
//                throw new \RuntimeException(sprintf('There is a file named "%s". This needs to be a directory and must contain the commands supported by the debugger backend %s.'),$local_path, get_class($this) );
//            }
            if (file_exists($local_path) && is_dir($local_path)) {
                $files_arr = glob($local_path.'*.php');
                $namespace = $RClass->getNamespaceName();
                foreach ($files_arr as $file) {
                    $command_class_name = $namespace.'\\'.$class_name.'Commands\\'.basename($file,'.php');
                    $this->commands[] = new $command_class_name();
                }
            }

            //
            $current_class = $RClass->getParentClass()->name;
        } while ($current_class !== __CLASS__);


    }

    public function handle(string $command) : ?string
    {
        $ret = NULL;
        foreach ($this->commands as $CommandHandler) {
            $ret = $CommandHandler->handle($command);
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