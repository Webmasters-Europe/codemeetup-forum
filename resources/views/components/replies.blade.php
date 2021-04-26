<ul >
    @foreach ($reply->reply as $reply)
        <li>
            @markdown($reply->content)
            by
            @if ($reply->user->trashed())
                a deleted user,
            @else
                <a href=" {{ route('users.show', $reply->user) }}">{{$reply->user->username}}</a>,
            @endif
            created at {{ $reply->created_at->format('d.m.Y H:i:s') }}

            @can('create post replies')
                <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#replyModal_{{$reply->id}}" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">
                    {{__('Comment') }}
                </button>
            @endcan

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
                                  <textarea rows="10" cols="64" name="content" class="tinymce">{{ old('content') }}</textarea>
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
              @endauth
        </li>
    @endforeach
</ul>
