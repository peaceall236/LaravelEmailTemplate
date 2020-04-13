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
            'templates' => \config('laravelemailtemplate.templates', [])
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
        //
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
