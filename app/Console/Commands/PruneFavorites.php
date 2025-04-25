<?php

namespace App\Console\Commands;

use App\Models\Favorite;
use Illuminate\Console\Command;

class PruneFavorites extends Command
{
    protected $signature = 'favorites:prune';
    protected $description = 'Удаляет избранные товары, которые не использовались больше месяца';

    public function handle(): void
    {
        $deleted = Favorite::where('updated_at', '<', now()->subMonth())->delete();
        $this->info("Удалено записей: $deleted");
    }
}
