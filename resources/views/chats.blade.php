@extends('layouts.app')

@section('styles')


@endsection


@section('content')

<chat :recipient="{{ $recipient }}" :sender="{{ auth()->user() }}"></chat>

@endsection