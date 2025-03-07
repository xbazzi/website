@extends('_layouts.main')

@section('body')
<div class="max-w-4xl mx-auto">
    <x-terminal-window title="{{$page->title}}" icon="lightbulb">
        <p class="font-bold text-xsm pl-4 pt-4 text-verde text-xs">Written by {{$page->author}} on {{date('m-d-y', $page->date)}}</p>
        <div class="my-4 mx-auto prose prose-invert prose-img:max-w-lg prose-img:mx-auto">
            @yield('content')
        </div>
    </x-terminal-window>
</div>
@endsection