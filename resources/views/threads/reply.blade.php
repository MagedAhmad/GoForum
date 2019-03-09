    <div class="card">
        <div class="card-header"> 
            <h5 class="level">
                <b class="flex">
                    <a href="#">{{$reply->user->name }}</a> 
                    said {{ $reply->created_at->diffForHumans()}} ...

                </b> 
                <form method="POST" action="/replies/{{$reply->id}}/favorites">
                    {{ csrf_field()}}
                    <button type="submit" class="btn btn-default" 
                        {{ $reply->isFavorited() ? 'disabled' : '' }} 
                        name="submit">
                        
                        {{ $reply->favorites()->count() }} 
                        {{ str_plural('Favorite', $reply->favorites()->count() )}}

                    </button>
                </form>

            </h5>
            
        </div>

        <div class="card-body">
            <article>
                <p>{{ $reply->body }}</p>
                <hr>
                
            </article>
        </div>
    </div>
    <br>