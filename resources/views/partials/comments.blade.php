<?php $subject instanceof \App\Models\Description ? $instance = 'description' : $instance = 'lead' ?>

<div class="panel panel-primary shadow">
    <div class="panel-heading"><h3><i class="fa fa-commenting" aria-hidden="true"> <b> Nội dung thảo luận</b></i></h3></div>
</div>

<?php $count = 0;?>
<?php $i = 1 ?>
@foreach($subject->comments as $comment)
    <div class="panel panel-primary shadow" style="margin-top:15px; padding-top:10px;">
        <div class="panel-body">
            <p class="smalltext">{{ __('Bình luận bởi') }}: <img src="{{url($comment->user->avatar)}}" class="notification-profile-image"><a
                        href="{{route('users.show', $comment->user->id)}}"> {{$comment->user->name}} </a>
            </p>
            <p class="smalltext">{{ __('Vào lúc') }}:
                {{ date('d F, Y, H:i:s', strtotime($comment->created_at))}}
                @if($comment->updated_at != $comment->created_at)
                    <br/>{{ __('Modified') }} : {{date('d F, Y, H:i:s', strtotime($comment->updated_at))}}
                @endif</p>
            <p>{!! $comment->description !!}</p>
        </div>
    </div>
@endforeach
<br/>

@if($instance == 'description')
    {!! Form::open(array('url' => array('/comments/description',$subject->id, ))) !!}
    <div class="form-group">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'comment']) !!}

        {!! Form::submit( __('Thêm bình luận') , ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@else
    {!! Form::open(array('url' => array('/comments/lead',$lead->id, ))) !!}
    <div class="form-group">
        {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'comment-field']) !!}

        {!! Form::submit( __('Add Comment') , ['class' => 'btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
@endif

@push('scripts')
    <script>
        $('#comment-field').atwho({
            at: "@",
            limit: 5, 
            delay: 400,
            callbacks: {
                remoteFilter: function (t, e) {
                    t.length <= 2 || $.getJSON("/users/users", {q: t}, function (t) {
                        e(t)
                    })
                }
            }
        })
    </script>
@endpush