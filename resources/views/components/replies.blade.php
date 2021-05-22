<br>
<ul>
    @foreach ($reply->reply as $reply)
        <li class="list-unstyled w-100">
            @if ($reply->user->trashed())<i>deleted user</i>
            @else <strong><a href=" {{ route('users.show', $reply->user) }}">{{$reply->user->username}}</a></strong>
            @endif
            <small>{{ $reply->created_at->diffForHumans()}}</small>
            @markdown($reply->content)
            <div class="text-right">
                @can('create post replies')
                    <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#replyModal_{{$reply->id}}">
                        {{__('Comment') }}
                    </button>
                @endcan

                @can ('edit reply')
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#editReplyModal_{{$reply->id}}">
                    {{__('Edit') }}
                </button>
                @endcan
                @auth
                    @if(auth()->user()->can('delete own post replies') && $reply->user->id == auth()->user()->id)
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#deleteReplyModal_{{$reply->id}}">
                            {{__('Delete') }}
                        </button>
                    @else
                        @can ('delete any post replies')
                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#deleteReplyModal_{{$reply->id}}">
                                {{__('Delete') }}
                            </button>
                        @endcan
                    @endif
                @endauth
            </div>

            <!-- Begin reply Modal -->
            @can('create post replies')
            <div class="modal fade" id="replyModal_{{$reply->id}}" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="replyModalLabel">{{__('Leave a comment') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form action="{{ route('replies.store', [$post, $reply]) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <textarea rows="10" name="content" class="tinymce w-100">{{ old('content') }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close') }}</button>
                                <button type="submit" class="btn">{{__('Save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endcan
            <!-- End reply Modal -->

            @can ('edit reply')
            <!-- begin update reply modaL -->
            <div class="modal fade" id="editReplyModal_{{$reply->id}}" tabindex="-1" role="dialog" aria-labelledby="editReplyModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="editReplyModalLabel">{{__('Edit Reply') }}</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form action="{{ route('replies.update', $reply->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="modal-body">
                                <x-easy-mde name="content" :options="['hideIcons' => ['image']]">
                                    {{ $reply->content }}
                                </x-easy-mde>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('Close') }}</button>
                                <button type="submit" class="btn">{{__('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end update reply modaL -->
            @endcan

            <!-- begin delete reply modal -->
            @canany (['delete any post replies', 'delete own post replies'])
            <div class="modal fade" id="deleteReplyModal_{{$reply->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteReplyModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="deleteReplyModalLabel">{{__('Delete this reply') }}?</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <p>{{$reply->content}}<br><small>{{ __('by') }}: {{$reply->user->username}}</small></p>
                        </div>
                        <div class="modal-footer">

                            <form action="{{ route('replies.destroy', ['postReply' => $reply ]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="button" class="btn" data-dismiss="modal">{{__('Close') }}</button>
                                <button type="submit" class="btn btn-secondary">{{__('Delete') }}</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            @endcanany
            <!-- end delete reply modal -->

            <hr>

            <x-replies :reply="$reply" :post="$post" />

        </li>
    @endforeach
</ul>
