@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12">
            
                @include('threads._list')
                
                <div style="margin:0 auto">
                    {{ $threads->render() }}
                </div>

        </div>
        

        
    </div>
</div>
@endsection
