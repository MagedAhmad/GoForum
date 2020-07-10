@extends('layouts.app')

@section('title')
    - {{ "Update profile" }}
@endsection

@section('content')

	<div class="mx-auto md:w-3/5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-12">
                    <div class="card">
                        <div class="card-header bg-gray-600 text-white font-bold">Update User</div>

                        <div class="card-body">
                            <article>
                                <form action="{{ url('/profiles/' . $user->name) }}" method="POST">
                                    {{ method_field('PATCH')}}
                                    @csrf
                                    <div class="form-group">
                                        <label>User name</label>
                                        <input type="text" name="name" value="{{$user->name}}" class="form-control">
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="submit" class="px-4 py-2 bg-gray-600 text-white" name="submit" value="UPDATE">
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
	</div>


@endsection