<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Resume;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $rules = [
        "resume_id" => "required|numeric",
        "theme_id" => "required|numeric",
        "visibility" => "nullable|string|in:public,private,hidden"
    ];

    public function __construct()
    {
        $this->middleware('auth');
        $this->jsonResumeApi = config('services.jsonresume.api');
    }

    public function index()
    {
        $publications = auth()->user()->publications;
        return view('publications.index', compact('publications'));
    }

    public function preview(Request $request)
    {
        $data = $request->validate($this->rules);
        $theme = Theme::findOrFail($data["theme_id"]);
        $resume = Resume::findOrFail($data["resume_id"]);

        if (auth()->user()->id !== $resume["user_id"]) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $this->render($resume, $theme);
    }


    private function render(Resume $resume, Theme $theme)
    {
        $URI = "{$this->jsonResumeApi}/theme/$theme->theme";
        $response = Http::post($URI, [
            "resume" => $resume->content,
        ]);
        return response($response, $response->status());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resumes = auth()->user()->resumes;
        $themes = Theme::all();
        return view("publications.edit", compact('resumes', 'themes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules);
        // dd($data);
        $publication = auth()->user()->publications()->create($data);
        $url = route("publications.show", $publication->id);
        $publication->update(compact('url'));

        $resume = $publication->resume()->get()->first();
        $theme = $publication->theme()->get()->first();
        return redirect()->route("publications.index")->with("alert", [
            "type" => "success",
            "messages" => [
                "Resume $resume->title published successfully with theme $theme->theme at <a href='$url'>$url</a>",
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        if ($publication->visibility === 'private') {
            if (!auth()->check()) {
                return redirect(route('login'));
            }
            if (auth()->user()->id !== $publication->user_id) {
                abort(Response::HTTP_FORBIDDEN);
            }
        }

        return $this->render($publication->resume, $publication->theme);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit(Publication $publication)
    {
        $this->authorize('update', $publication);
        $resumes = auth()->user()->resumes;
        $themes = Theme::all();

        // dd($publication);


        return view('publications.edit', compact('publication', 'resumes', 'themes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        $data = $request->validate($this->rules);
        $this->authorize('update', $publication);
        $publication->update($data);

        return redirect(route('publications.index'))->with('alert', [
            'type' => 'success',
            'messages' => ["Publication {$publication->url} updated"]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        //
    }
}