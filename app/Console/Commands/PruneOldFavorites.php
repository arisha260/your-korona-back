<?php

namespace App\Console\Commands;

use App\Models\Favorite;
use Illuminate\Console\Command;

class PruneOldFavorites extends Command
{
    protected $signature = 'favorites:prune';
    protected $description = 'Удаляет избранные, не использованные более месяца';

    public function handle()
    {
        $deleted = Favorite::where('updated_at', '<', now()->subMonth())->delete();
        $this->info("Удалено избранных: {$deleted}");
    }
}
