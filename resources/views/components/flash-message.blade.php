@props(['status'=>'info'])

@php
if(session('status') === 'info'){$bgcolor = 'bg-blue-300';}
if(session('status') === 'alert'){$bgcolor = 'bg-red-300';}
@endphp


@if(session('message'))
  <div class="{{$bgcolor}} w-1/2 mx-auto p-2 text-white">
    {{session('message')}}
  </div>
@endif


