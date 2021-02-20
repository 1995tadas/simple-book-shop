<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteBooksCovers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covers:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes all files from storage folder covers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exists = Storage::exists('/covers');
        if (!$exists) {
            $this->error(__('command.no_cover'));
            return 0;
        }

        $images = Storage::allFiles('/covers');

        $deleted = Storage::delete($images);
        if ($deleted) {
            $this->info(__('command.cover_delete_success'));
        }
    }
}
