<div class="col-md-8">
    <div class="card">
        <div class="card-header"> <b><a href="#">{{$reply->user->name }}</a> </b> said
         {{ $reply->created_at->diffForHumans()}} ...</div>

        <div class="card-body">
            <article>
                <p>{{ $reply->body }}</p>
                <hr>
                
            </article>
        </div>
    </div>
</div>