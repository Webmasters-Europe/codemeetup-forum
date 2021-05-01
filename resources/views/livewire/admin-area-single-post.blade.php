<div>

    <h1>{{ $post->title }}</h1>

    @markdown($post->content)    

    <div>
        by
        @if ($post->user->trashed())
            a deleted user
        @else
            <a href=" {{ route('users.show', $post->user) }}">{{$post->user->username}}</a>
        @endif
    </div>
    
    <div>created at {{ $post->created_at->format('d.m.Y H:i:s') }}</div>

    {{-- begin show all uploads to this post --}}
    <div>
        <p>Images:</p>
        @forelse ($images as $image)
            <img src="{{ asset('storage/'.$image->filename) }}" width="100" alt="">
        @empty
            No uploded images for this post.
        @endforelse
        <p>Files:</p>
        <ul>
            @forelse ($otherFiles as $otherFile)
                <li><a href="{{ asset('storage/'.$otherFile->filename) }}">{{ basename($otherFile->filename) }}</a></li>
            @empty
                No uploded Files for this post.
            @endforelse
        </ul>
    </div>
    {{-- end show all uploads to this post --}}

    <div>
        @can ('update post') 
            <a href="" class="btn btn-sm btn-primary">Edit</a>
        @endcan

        @can ('delete post')
        <button wire:click="selectPost({{ $post->id }}, 'delete')"
            class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i>
        </button>
        @endcan
    </div>

    <hr>
    <!-- begin show PostReplies -->

    <div>
        <h1>Replies:</h1>
        @forelse ($replies as $reply)
        <ul class="row border my-2 p-2 no-gutters">
            <li class="list-unstyled">
                
                @markdown($reply->content)

                by
                @if ($reply->user->trashed())
                    a deleted user,
                @else
                    <a href=" {{ route('users.show', $reply->user) }}">{{$reply->user->username}}</a>,
                @endif
                created at {{ $reply->created_at->format('d.m.Y H:i:s') }}

                @can ('update post') 
                    <a href="" class="btn btn-sm btn-primary">Edit</a>
                @endcan
    
                @can ('delete post')
                    <a href="" class="btn btn-sm btn-primary">Delete</a>
                @endcan

                {{-- show reply to reply --}}
                <x-replies :reply="$reply" :post="$post" />

                <!-- Begin Modal -->
                @can('create post replies')
                <div class="modal fade" id="replyModal_{{$reply->id}}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="replyModalLabel">{{__('Leave a comment') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('replies.store', [$post, $reply]) }}" method="POST">
                                    @csrf
                                    <x-easy-mde name="content" :options="['hideIcons' => ['image']]">{{ old('content') }}</x-easy-mde>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">{{__('Close') }}</button>
                                <button type="submit" class="btn btn-success">{{__('Save') }}</button>
                            </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- End Modal -->
                @endcan
            </li>
        </ul>

        @empty
        <li class="row border my-2 p-2 no-gutters">
                No replies found for this post.
        </li>
        @endforelse

        {{ $replies->links() }}

    </div> <!-- end show PostReplies -->  
</div>
