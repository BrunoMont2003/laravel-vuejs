@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="border rounded">
            <div class="container my-3">
                @if (isset($publication))
                    <form method="POST" action="{{ route('publications.update', $publication->id) }}">
                        @method('PUT')
                    @else
                        <form method="POST" action="{{ route('publications.store') }}">
                @endif
                @csrf
                <div class="row">
                    <div class="col-md-4 p-3">
                        <label for="resume" class="form-label">Resume</label>
                        <select id="resume" name="resume_id" class="form-select">
                            <option selected disabled value="">Choose...</option>
                            @foreach ($resumes as $resume)
                                @if (isset($publication) && $publication->resume->id == $resume->id)
                                    <option selected value={{ $resume->id }}>{{ $resume->title }}
                                    </option>
                                @else
                                    <option value={{ $resume->id }}>{{ $resume->title }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 p-3">
                        <label for="theme" class="form-label">Theme</label>
                        <select id="theme" name="theme_id" class="form-select">
                            <option selected disabled value="">Choose...</option>
                            @foreach ($themes as $theme)
                                @if (isset($publication) && $publication->theme->id == $theme->id)
                                    <option selected value={{ $theme->id }}>{{ $theme->theme }}
                                    </option>
                                @else
                                    <option value={{ $theme->id }}>{{ $theme->theme }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                    <div class="col-md-4 p-3">
                        <label for="visibility" class="form-label">Visibility</label>
                        <select name="visibility" class="form-select">
                            <option selected disabled>Choose...</option>
                            @foreach (['public', 'private', 'hidden'] as $visibility)
                                @if (isset($publication) && $publication->visibility == $visibility)
                                    <option selected value={{ $visibility }}>{{ $visibility }}
                                    </option>
                                @else
                                    <option selected value={{ $visibility }}>{{ $visibility }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 p-3">
                        <button class="btn btn-primary px-5" type="submit">Save</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="mt-3">
            <iframe id="iframe" frameborder="0" class="opacity-0 border rounded w-100" style="height: 640px"></iframe>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const iframe = document.getElementById('iframe')
        const resume = document.getElementById('resume')
        const theme = document.getElementById('theme')


        const loadPreview = async (resume_id, theme_id) => {
            iframe.srcdoc = "<h1>Loading Preview ...</h1>"
            iframe.classList.remove('opacity-0')
            try {
                const {
                    data
                } = await axios.post("/publications/preview", {
                    resume_id,
                    theme_id
                })
                iframe.srcdoc = data

            } catch (error) {
                console.log(error)
            }
        }
        if (resume.value && theme.value) {
            await loadPreview(resume.value, theme.value)
        }
        resume.addEventListener('change', async ({
            target: {
                value
            }
        }) => {
            theme.value && await loadPreview(value, theme.value)
        })
        theme.addEventListener('change', async ({
            target: {
                value
            }
        }) => {
            resume.value && await loadPreview(resume.value, value)
        })
    })
</script>
