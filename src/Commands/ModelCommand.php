<?php

namespace AdminKit\Directories\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModelCommand extends Command
{
    protected $signature = 'admin-kit:model-directory {name}';

    protected $description = 'Make Directory Model';

    private string $singularName;
    private string $snakeDashName;
    private string $snakeUnderscoreName;
    private array $replacement;

    public function handle()
    {
        $this->initialVariables();
        $this->createFolders();
        $this->createFiles();

        // display navigation in console
        $config = file_get_contents(__DIR__ . '/../../stubs/config/admin-kit.stub');
        $config = str_replace(array_keys($this->replacement), array_values($this->replacement), $config);
        $this->comment('// вставить в файл: config/admin-kit.php');
        $this->info($config);
    }

    private function initialVariables()
    {
        $name = $this->argument('name');
        $this->singularName = Str::singular(Str::studly($name));
        $this->snakeDashName = Str::plural(Str::snake(Str::studly($name), '-'));
        $this->snakeUnderscoreName = Str::plural(Str::snake(Str::studly($name), '_'));
        $this->replacement = [
            '{SingularName}' => $this->singularName,
            '{snake-dash-name}' => $this->snakeDashName,
            '{snake_underscore_name}' => $this->snakeUnderscoreName,
        ];
    }

    private function fileBindings(): array
    {
        return [
            __DIR__ . '/../../stubs/app/Models/Template.stub' => app_path("Models/$this->singularName.php"),
        ];
    }

    private function createFolders()
    {
        if (!file_exists(app_path('/Models'))) {
            mkdir(app_path('/Models'), 0777, true);
        }
    }

    private function createFiles()
    {
        foreach ($this->fileBindings() as $path => $target) {
            $content = file_get_contents($path);
            File::put($target, str_replace(array_keys($this->replacement), array_values($this->replacement), $content));
        }
    }
}
