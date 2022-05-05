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
    public function create()
    {
        $resume = json_encode(Resume::factory()->make());
        return view('resumes.create', compact('resume'));
    }
    private function savePicture($blob)
    {
        list($type, $blob) = explode(';', $blob);
        list(, $blob)      = explode(',', $blob);
        $blob = base64_decode($blob);
        $file_path = "/var/www/storage/app/public/pictures";
        $file_name = Str::uuid();
        file_put_contents("$file_path/$file_name.png", $blob);
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
            return response($th);
        }
    }
}