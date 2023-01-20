<?php

namespace AdminKit\Directories\Commands;

use Illuminate\Console\Command;

class DirectoriesCommand extends Command
{
    public $signature = 'directories';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
