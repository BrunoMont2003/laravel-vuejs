<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResume;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Resume;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;

class ResumeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $resumes = auth()->user()->resumes;
        return view("resumes.index", compact('resumes'));
    }

    public function create()
    {
        $resume = json_encode(Resume::factory()->make());
        return view('resumes.create', compact('resume'));

        // return view('resumes.create');
    }
    private function savePicture($blob)
    {
        list($type, $blob) = explode(';', $blob);
        list(, $blob)      = explode(',', $blob);
        $blob = base64_decode($blob);
        $file_path = "/var/www/storage/app/public/pictures";
        $file_name = Str::uuid();
        file_put_contents("$file_path/$file_name.png", $blob);
        $file_path = "/storage/pictures";
        return "$file_path/$file_name.png";
    }
    public function store(StoreResume $request)
    {
        try {
            $data = $request->validated();
            $picture = $data['content']["basics"]["picture"];
            if ($picture !== "/storage/pictures/cat.png") {
                $uri = $this->savePicture($picture);
                $data['content']["basics"]["picture"] = $uri;
            }
            // dd($data);
            $resume = auth()->user()->resumes()->create($data);
            return response($resume, Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response($th, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function edit(Resume $resume)
    {
        $this->authorize("update", $resume);
        return view('resumes.edit', compact('resume'));
    }

    public function update(Resume $resume, StoreResume $request)
    {
        $this->authorize("update", $resume);
        try {
            $data = $request->validated();
            $picture = $data['content']['basics']['picture'];
            if ($resume->content['basics']['picture'] !== $picture) {
                $uri = $this->savePicture($picture);
                $data['content']["basics"]["picture"] = $uri;
            }
            $resume->update($data);
            return response($data, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response($th);
        }
    }
}