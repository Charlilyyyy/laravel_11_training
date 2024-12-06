@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{-- <div class="col-md-8 mb-5">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div> --}}

            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-header">Create Post</div>

                    <div class="card-body">
                        <form id="create_post" method="POST" enctype="multipart/form-data" action="{{ route('postCreate') }}">
                            @csrf
                            @method('post')

                            <div class="mb-3">
                                <label for="context" class="form-label">Context</label>
                                <textarea class="form-control @error('context') is-invalid @enderror" name="context" id="context" rows="3"></textarea>
                                @error('context')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <button class="btn btn-primary" type="submit" form="create_post">Submit Post</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-3">
                <div class="d-flex btn-group w-100" role="group" aria-label="Basic example">
                    <a href="{{ route('home',['type' => 'home']) }}" class="w-50 btn text-decoration-none {{ $type == 'home' ? 'text-dark btn-light' : 'text-light btn-dark' }} ">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="d-none d-md-inline">
                            Home
                        </span>
                    </a>
                    <a href="{{ route('home',['type' => 'my_posts']) }}" class="w-50 btn text-decoration-none t{{ $type == 'my_posts' ? 'ext-dark btn-light' : 'ext-light btn-dark' }} ">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="d-none d-md-inline">
                            My Posts
                        </span>
                    </a>
                    <a href="{{ route('home',['type' => 'my_replies']) }}" class="w-50 btn text-decoration-none {{ $type == 'my_replies' ? 'text-dark btn-light' : 'text-light btn-dark' }} ">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="d-none d-md-inline">
                            My Replies
                        </span>
                    </a>
                    <a href="{{ route('home',['type' => 'my_bookmarks']) }}" class="w-50 btn text-decoration-none {{ $type == 'my_bookmarks' ? 'text-dark btn-light' : 'text-light btn-dark' }} ">
                        <i class="bi bi-bookmark-fill"></i>
                        <span class="d-none d-md-inline">
                            My Bookmarks
                        </span>
                    </a>
                </div>
            </div>

            <div class="col-md-8 mb-5">

                <div class="card">
                    {{-- <div class="card-header">Feed</div> --}}

                    <div class="card-body">
                        <table class="table table-hover w-100">
                            @foreach ($postPlural as $post)
                                <tr>
                                    <td>
                                        @include('post')
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-4">
                            {!! $postPlural->appends(request()->except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
