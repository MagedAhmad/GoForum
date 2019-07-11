@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row" style="margin-top:10%;">
        <div class="col-md-4 text-center">

        </div>
        <div class="col-md-4 text-center">
            <h5>Technologies used</h5>
            <div>
                <p>phpunit, Laravel, Redis, Vue, bootstrap</p>
            </div>
            <hr>
            <div>
                <h5>Note</h5>
                <p>My shared hosting doesn't support redis(caching driver) so i removed some features on the online version like
                <ul>
                    <li>Trending threads</li>
                    <li>mark already (opened/seen) threads</li>
                </ul>
                </p> 
                want to view full version ? <a target="_blank" href="https://github.com/MagedAhmad/GoForum">Check github Repo</a>
            </div>
        </div>
        
        <div class="col-md-4"></div>
    </div>
    

</div>


@endsection