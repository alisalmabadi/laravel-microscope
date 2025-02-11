<?php

namespace Imanghafoori\LaravelMicroscope\Commands;

use Illuminate\Console\Command;
use Imanghafoori\LaravelMicroscope\Checks\CheckStringy;
use Imanghafoori\LaravelMicroscope\ErrorReporters\ErrorPrinter;
use Imanghafoori\LaravelMicroscope\ForPsr4LoadedClasses;

class ClassifyStrings extends Command
{
    protected $signature = 'check:stringy_classes';

    protected $description = 'Replaces string references with ::class version of them.';

    public function handle(ErrorPrinter $errorPrinter)
    {
        $this->info('Checking stringy classes...');
        app()->singleton('current.command', function () {
            return $this;
        });
        $errorPrinter->printer = $this->output;
        ForPsr4LoadedClasses::check([CheckStringy::class]);
        $this->getOutput()->writeln(' <fg=gray>✔ - Finished looking for stringy classes.</>');

        return $errorPrinter->hasErrors() ? 1 : 0;
    }
}
