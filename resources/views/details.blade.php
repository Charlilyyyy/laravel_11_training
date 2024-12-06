@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            {{-- {{ dd($postSingular) }} --}}
            <div class="col-md-8 mb-5">
                <div class="mb-3">
                    @if ($postSingular->parent_post_id != null)
                        <a href="{{ route('postDetail',[$postSingular->parent_post_id]) }}" class="btn btn-light">Return to Previous Post</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-light">Return to Home</a>
                    @endif
                </div>

                <div class="card">
                    {{-- <div class="card-header">Feed</div> --}}

                    <div class="card-body">
                        <table class="table table-borderless w-100">
                            <tr>
                                <td>
                                    @php
                                        $post = $postSingular;
                                    @endphp
                                    @include('post')
                                </td>
                            </tr>
                        </table>
                        <hr>

                        <table class="table table-hover w-100">
                            @foreach ($childPostPlural as $post)
                                <tr>
                                    <td class="py-0">
                                        <div class="d-flex">
                                            <div class="position-relative d-flex flex-column px-2">
                                                <div class="position-absolute bottom-0 start-50 translate-middle-x bg-secondary" style="width: 1px; height:100%">
                                                <span class="position-absolute top-0 start-50 translate-middle-x mt-3 text-secondary">
                                                    <i class=" bi bi-circle-fill"></i>
                                                </span>
                                                </div>
                                            </div>
                                            @include('post')
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="mt-4">
                            {!! $childPostPlural->appends(request()->except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
