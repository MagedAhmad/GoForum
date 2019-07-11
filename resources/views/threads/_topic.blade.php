<div class="card">
    <!-- Edit thread -->
    <div v-if="editing">
        <div class="card-header">
            <h5 class="level">
                <input type="text" class="form-control" v-model="form.title">
                
            </h5>
        </div>  

        <div class="card-body">
            <article>
                <wysiwyg name="body" v-model="form.body"></wysiwyg>
            </article>
        </div>
        <div class="card-footer flex justify-between">
            <div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-default" @click="reset">Cancel</button>
            </div>
            
            <div>
                @can('update', $thread)
                <form method="POST" action="{{$thread->path()}}">
                    {{ csrf_field()}}
                    {{ method_field('DELETE')}}
                    <button type="submit" class="btn btn-link">
                        Delete Thread
                    </button>
                </form>
                @endcan
            </div>
            
        </div>
    </div>

    <!-- View the thread -->
    <div v-if="! editing">
        <div class="card-header">
            <h5 class="level">
                <b class="flex">
                    <img src="{{ asset($thread->user->avatar_path) }}" width="25" height="25">
                    <a href="{{ route('profile',$thread->user->name)}}">{{$thread->user->name }} ({{ $thread->user->reputation .' XP' }})</a> 
                    <span v-text="this.title"></span>

                </b>

            </h5>
        </div>  

        <div class="card-body">
            <article>
                <p v-html="this.body"></p>
                <hr>
                
            </article>
        </div>
        <div class="card-footer flex justify-between">
            <div>
                <button class="btn btn-xs btn-primary" @click="editing = true">Edit</button>
            </div>
            
        </div>
    </div>

    
</div>