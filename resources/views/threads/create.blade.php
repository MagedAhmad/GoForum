@extends('layouts.app')

@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.1.1/trix.css">

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-12">
            <div class="card">
                <div class="card-header bg-gray-600 text-white font-bold">Create Thread</div>

                <div class="card-body">
                    <article>
                        <form method="POST" action="/threads">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select name="channel_id" class="form-control">
                                    <option>Choose Channel</option>
                                    @foreach($channels as $channel)
                                        <option value="{{$channel->id}}" {{$channel->id == old('channel_id') ? 'selected' : ''}}>{{$channel->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" value="{{old('title')}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Body</label>
                                <!-- <textarea class="form-control" name="body">{{old('body')}}</textarea>        -->
                                <wysiwyg name="body"></wysiwyg>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="px-4 py-2 bg-gray-600 text-white" name="submit" value="Publish">
                            </div>
                            
                        </form>
                        @if($errors->all())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </article>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
