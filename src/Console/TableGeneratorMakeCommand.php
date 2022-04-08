<?php

namespace Advicepharma\Tablegenerator\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class TableGeneratorMakeCommand extends GeneratorCommand
{
    use WithModelStub;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:advtable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new table class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'TableGenerator';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {

        return $this->resolveStubPath('/stubs/tablegenerator.model.stub');

    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\AdvTables';
    }

    /**
     * Build the class with the given name.
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [];
        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }else{
            $replace = $this->buildModelReplacements($replace);
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a table for the given model.'],
        ];
    }
}