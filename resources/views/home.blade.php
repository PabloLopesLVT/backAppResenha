@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script> // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('45ecad701a708b4980e9', {
          cluster: 'us2'
        });

        var channel = pusher.subscribe('notification-channel_'+{{ Auth::id() }});
        channel.bind('my-event', function(data) {
          alert(JSON.stringify(data));
        }); </script>
@stop
