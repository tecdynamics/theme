<?php

namespace Tec\Theme\Commands;

use Tec\Theme\Commands\Traits\ThemeTrait;
use Tec\Theme\Services\ThemeService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand('cms:theme:activate', 'Activate a theme')]
class ThemeActivateCommand extends Command implements PromptsForMissingInput
{
    use ThemeTrait;

    public function handle(ThemeService $themeService): int
    {
        if (! preg_match('/^[a-z0-9\-]+$/i', $this->argument('name'))) {
            $this->components->error('Only alphabetic characters are allowed.');

            return self::FAILURE;
        }

        $result = $themeService->activate($this->getTheme());

        if ($result['error']) {
            $this->components->error($result['message']);

            return self::FAILURE;
        }

        $this->components->info($result['message']);

        return self::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument('name', InputArgument::REQUIRED, 'The theme name that you want to remove assets');
        $this->addOption('path', null, InputOption::VALUE_REQUIRED, 'Path to theme directory');
    }
}
