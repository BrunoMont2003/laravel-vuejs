@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach ($publications as $publication)
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title overflow-hidden" style="text-overflow: ellipsis; white-space: nowrap;">
                                {{ $publication['resume']['title'] }}</h5>
                            <a href="{{ $publication['url'] }}">{{ $publication['url'] }}</a>
                            <p>{{ $publication['created_at'] }}</p>
                            <div class="d-flex gap-3">

                                <a href="{{ route('publications.edit', $publication->id) }}" class="btn btn-primary">
                                    <font-awesome-icon icon="pencil"></font-awesome-icon>
                                    <span class="ml-1">
                                        EDIT
                                    </span>
                                </a>
                                <form method="POST" action="{{ route('publications.destroy', $publication->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <font-awesome-icon icon="trash"></font-awesome-icon>
                                        <span class="ml-1">
                                            DELETE
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
