<?php

namespace Alliance\LaravelEmailTemplate\Http\Controllers;

use Alliance\LaravelEmailTemplate\Models\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaravelEmailTemplateController extends Controller
{
    /**
     * Initialize controller and add custom middleware
     */
    public function __construct() {
        $middleware = \config('laravelemailtemplate.middleware', []);
        foreach ($middleware as $key) {
            $this->middleware($key);
        }
    }

    /**
     * Display a listing of laravel email template.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("laravelemailtemplate::index", [
            'templates' => \config('laravelemailtemplate.templates', []),
            "on_queue" => Template::where('status', '<>', Template::STATUS_COMPLETED)->count(),
            'uploads' => Template::where('status', '<>', Template::STATUS_COMPLETED)->limit(10)->get(),
            'retry_status' => Template::STATUS_FAILED
        ]);
    }

    /**
     * Store a newly created laravel email template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $templates = \config('laravelemailtemplate.templates', []);
        $templates_size = \count($templates);
        if ($templates_size === 0) {
            return \redirect()->route('laravelemailtemplate.index');
        }

        // validate submitted data
        $request->validate([
            'entryFileName' => "required",
            'templateZip' => "required|file|mimes:zip",
            'templateIndex' => "required|in:" . implode(",", array_keys($templates))
        ]);

        // upload zip file
        $filename = time() . "template_" . $request->templateIndex . ".zip";
        $path = $request->file('templateZip')->storeAs('laravelemailtemplates', $filename);


        // create template
        $template = new Template;
        $template->name = $templates[$request->templateIndex]["name"];
        $template->template_index = $request->templateIndex;
        $template->entry_file = $request->entryFileName;
        $template->storage_location = $path;
        $template->save();

        // 
        return \redirect()->route('laravelemailtemplate.index')->with('status', 'Template upload was added on queue.');

    }

    /**
     * Update the specified laravel email template in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Alliance\LaravelEmailTemplate\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Template $template)
    {
        //
    }

    /**
     * Remove the specified laravel email template from storage.
     *
     * @param  \Alliance\LaravelEmailTemplate\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        //
    }

}
