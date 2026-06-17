<?php

/**
 * This file is part of the TwigBridge package.
 *
 * @copyright Robert Crowe <hello@vivalacrowe.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RaiderBridge\Command;

use Illuminate\Console\Command;

/**
 * Artisan command to clear the Twig cache.
 */
class Clean extends Command
{
    /**
     * {@inheritdoc}
     */
    protected $name = 'twig:clean';

    /**
     * {@inheritdoc}
     */
    protected $description = 'Clean the Twig Cache';

    public function fire()
    {
        return $this->handle();
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $twig     = $this->laravel['raider'];
        $files    = $this->laravel['files'];
        $cacheDir = $twig->getCache();

        if (feature_flag('sbsFixTwigDirectory', false)) {
            $files->deleteDirectory(storage_path('framework/views/twig'));
        } else {
            $files->deleteDirectory($cacheDir);
        }

        if ($files->exists($cacheDir)) {
            $this->error('Twig cache failed to be cleaned');
        } else {
            $this->info('Twig cache cleaned');
        }
    }
}
