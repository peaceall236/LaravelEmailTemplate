<?php

namespace Alliance\LaravelEmailTemplate\Console\Commands;

use Alliance\LaravelEmailTemplate\Models\Template;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExtractEmailTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravelemailtemplate:extract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract uploaded email template';

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
     * @return mixed
     */
    public function handle()
    {
        //
        if (Template::where("status", "=", Template::STATUS_PROCESSING)->count() == 0) {
            $template = Template::where("status", "=", Template::STATUS_PENDING)->first();
            if ($template) {
                $templates = \config('laravelemailtemplate.templates', []);
                $template_folder = trim($templates[$template->template_index]["folder"], "/");
                $template_entry_file = $templates[$template->template_index]["entry_file"];

                if (empty($template_entry_file) || empty($template_folder)) {
                    // Invalid configuration
                    $template->status = Template::STATUS_FAILED;
                    $template->status_description = "Invalid configuration";
                    $template->save();
                    return;
                }


                $resource_template_folder = \resource_path('views/' . $template_folder);

                $zip = new \ZipArchive;
                if (!$zip->open(\storage_path('app/' . $template->storage_location))) {
                    // could not open zip file
                    $template->status = Template::STATUS_FAILED;
                    $template->status_description = "could not open zip file";
                    $template->save();
                    return;
                }

                // clear destination folder first
                $this->deleteFolderContents($resource_template_folder);

                if (!$zip->extractTo($resource_template_folder)) {
                    // could not extract to destination folder
                    $template->status = Template::STATUS_FAILED;
                    $template->status_description = "could not extract to destination folder";
                    $template->save();
                    return;
                }

                // Close zip instance
                $zip->close();

                if (!\rename($resource_template_folder . "/" . $template->entry_file,
                    $resource_template_folder . "/" . $template_entry_file))
                {
                    // Could not rename entry file
                    $template->status = Template::STATUS_FAILED;
                    $template->status_description = "Could not rename entry file";
                    $template->save();
                    return;
                }

                $template->status = Template::STATUS_COMPLETED;
                $template->status_description = "Template processed successful";
                $template->save();

                Storage::delete($template->storage_location);
                
            }
        }
    }

    /**
     * Deletes the contents of a folder
     * 
     * @param string $path
     */
    private function deleteFolderContents($path) {
        $contents = \glob($path . "/*");
        foreach($contents as $content) {
            if (\is_file($path . "/" . $content)) {
                \unlink($path . "/" . $content);
            } else {
                if (\is_dir($path . "/" . $content)) {
                    deleteFolderContents($path . "/" . $content);
                }
            }
        }
    }
}
