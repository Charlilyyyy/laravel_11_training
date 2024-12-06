<div class="d-flex flex-column p-3 w-100">
    <div class="d-flex justify-content-between">
        <b class="">
            {{ $post->userSingular->name }}
        </b>
        <span class="text-muted">
            @if ($post->user_id == Auth::id())
                <div class="btn-group">
                    <button class="btn btn-light rounded" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        style="--bs-btn-padding-y: .0rem; --bs-btn-padding-x: .25rem; --bs-btn-font-size: .75rem;">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" class="dropdown-item" data-bs-toggle="modal"
                                data-bs-target="#edit_{{ $post->id }}">Edit</a></li>
                        <li><button type="submit" class="dropdown-item"
                                form="delete_post_{{ $post->id }}">Delete</button></li>
                    </ul>
                </div>
            @endif
            {{ date('d-m-Y h:i A', strtotime($post->created_at)) }}
        </span>
    </div>
    <a class="py-3 text-dark text-decoration-none" href="{{ route('postDetail', [$post->id]) }}">
        {{ $post->content }}
        @if ($post->created_at != $post->updated_at)
            edited
        @endif
    </a>
    <div class="d-flex btn-group w-100" role="group" aria-label="Basic example">
        <a class="w-75 btn text-decoration-none text-muted btn-light" data-bs-toggle="modal"
            data-bs-target="#reply_{{ $post->id }}">
            <i class=" bi bi-chat-fill"></i>
            {{ $post->childPostPlural->count() }}
            <span class="d-none d-md-inline">
                Replies
            </span>
        </a>
        <a href="{{ route('postInteract', [$post->id]) }}" class="w-75 btn text-decoration-none text-muted btn-light">
            @if ($post->interactionPlural->where('user_id', Auth::id())->first())
                <i class="bi bi-bookmark-fill"></i>
                {{ $post->interactionPlural->count() }}
                <span class="d-none d-md-inline">
                    Bookmarked
                </span>
            @else
                <i class="bi bi-bookmark"></i>
                {{ $post->interactionPlural->count() }}
                <span class="d-none d-md-inline">
                    Bookmark
                </span>
            @endif
        </a>
    </div>

    {{-- Reply Modal --}}
    <div class="modal fade" id="reply_{{ $post->id }}" tabindex="-1"
        aria-labelledby="reply_{{ $post->id }}_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="reply_{{ $post->id }}_label">Reply</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reply_form_{{ $post->id }}" method="POST" enctype="multipart/form-data"
                        action="{{ route('postCreate', [$post->id]) }}">
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

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" form="reply_form_{{ $post->id }}">Submit
                        Reply</button>
                </div>
            </div>
        </div>
    </div>

    @if ($post->user_id == Auth::id())
        <form id="delete_post_{{ $post->id }}" method="POST" enctype="multipart/form-data"
            action="{{ route('postDelete', [$post->id]) }}">
            @csrf
            @method('delete')
        </form>

        {{-- Edit Modal --}}
        <div class="modal fade" id="edit_{{ $post->id }}" tabindex="-1"
            aria-labelledby="edit_{{ $post->id }}_label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="edit_{{ $post->id }}_label">Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_form_{{ $post->id }}" method="POST" enctype="multipart/form-data"
                            action="{{ route('postUpdate', [$post->id]) }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="context" class="form-label">Context</label>
                                <textarea class="form-control @error('context') is-invalid @enderror" name="context" id="context" rows="3">{{ $post->content }}</textarea>
                                @error('context')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit"
                            form="edit_form_{{ $post->id }}">Save</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
