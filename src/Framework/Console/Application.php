<?php

namespace Framework\Console;

use Framework\Console\Commands\InstallAuth;
use Framework\Console\Commands\MakeController;
use Framework\Console\Commands\MakeMiddleware;
use Framework\Console\Commands\MakeMigration;
use Framework\Console\Commands\MakeModel;

class Application
{
    protected array $commands = [];

    public function __construct()
    {
        $this->register(new MakeController());
        $this->register(new MakeModel());
        $this->register(new MakeMiddleware());
        $this->register(new MakeMigration());
        $this->register(new InstallAuth());
    }

    public function register(Command $command): void
    {
        $this->commands[$command->signature()] = $command;
    }

    public function run(array $argv): void
    {
        $command = $argv[1] ?? null;
        if (!$command || !isset($this->commands[$command])) {
            $this->list();
            return;
        }
        $this->commands[$command]->handle(array_slice($argv, 2));
    }

    protected function list(): void
    {
        $RESET = "\033[0m";
        $BLACK   = "\033[30m";
        $RED     = "\033[31m";
        $GREEN   = "\033[32m";
        $YELLOW  = "\033[33m";
        $BLUE    = "\033[34m";
        $MAGENTA = "\033[35m";
        $CYAN    = "\033[36m";
        $WHITE   = "\033[37m";
        $GRAY    = "\033[90m";
        $BOLD      = "\033[1m";
        $DIM       = "\033[2m";
        $UNDERLINE = "\033[4m";


        $version = 'beta';
        echo $RED;
        echo <<<LOGO
███╗   ███╗██╗   ██╗████████╗ █████╗ 
████╗ ████║██║   ██║╚══██╔══╝██╔══██╗
██╔████╔██║██║   ██║   ██║   ███████║
██║╚██╔╝██║██║   ██║   ██║   ██╔══██║
██║ ╚═╝ ██║╚██████╔╝   ██║   ██║  ██║
╚═╝     ╚═╝ ╚═════╝    ╚═╝   ╚═╝  ╚═╝

LOGO;
        echo $RESET;
        echo "{$BLUE}PHP Framework Developed by: {$BOLD}Mutasem Mustafa{$RESET}\n";
        echo "{$YELLOW}Version:{$UNDERLINE}{$version}{$RESET}\n\n";
        echo "Muta CLI available commands:\n\n";
        foreach ($this->commands as $cmd) {
            echo " - {$GREEN}{$cmd->signature()}{$RESET} → {$cmd->description()}\n";
        }
    }
}