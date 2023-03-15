<?php

namespace Melogail\TelrLaravel\Commands;

use Illuminate\Console\Command;

class TelrLaravelCommand extends Command
{
    public $signature = 'telr-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
