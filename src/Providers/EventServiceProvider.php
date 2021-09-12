<?php

namespace Simbamahaba\Upepo\Providers;

use Simbamahaba\Upepo\Events\RecordDeletedEvent;
use Simbamahaba\Upepo\Listeners\DeleteRecordFilesListener;
use Simbamahaba\Upepo\Listeners\DeleteRecordFilesNamesListener;
use Simbamahaba\Upepo\Listeners\DeleteRecordImagesListener;
use Simbamahaba\Upepo\Listeners\DeleteRecordImagesNamesListener;

use Decoweb\Panelpack\Observers\FileObserver;
use Decoweb\Panelpack\Observers\ImageObserver;
use Decoweb\Panelpack\Observers\SysCoreSetupObserver;
use Simbamahaba\Upepo\Models\File;
use Simbamahaba\Upepo\Models\Image;
use Simbamahaba\Upepo\Models\SysCoreSetup;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        /* Must:
        * delete pics names from "images" table
        * delete physical pics from >storage/app/uploads
        * delete files names from "files" table
        * delete physical files from >storage/app/uploaded_files
       */
        RecordDeletedEvent::class => [
            DeleteRecordImagesListener::class,
            DeleteRecordImagesNamesListener::class,
            DeleteRecordFilesListener::class,
            DeleteRecordFilesNamesListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Image::observe(ImageObserver::class);
        File::observe(FileObserver::class);
        SysCoreSetup::observe(SysCoreSetupObserver::class);
    }
}
