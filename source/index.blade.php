@extends('_layouts.main')

@section('body')
    <!-- <div class="flex gap-4">
<div>

    <div class="bg-indigo-500 size-24 border border-black"></div>
    <div class="bg-indigo-500 size-24 border border-black"></div>
    <div class="bg-indigo-500 size-24 border border-black"></div>
    <div class="bg-indigo-500 size-24 border border-black"></div>
</div>
<div>

    <div class="bg-indigo-500 size-24 border border-black"></div>
    <div class="bg-indigo-500 size-24 border border-black"></div>
    <div class="bg-indigo-500 size-24 border border-black"></div>
    <div class="bg-indigo-500 size-24 border border-black"></div>
</div>
<div class="grid grid-cols-5 grid-rows-4 flex-1">
    <div class="bg-white col-span-1 row-start-1 row-end-1 col-start-2  border-black"></div>
    <div class="bg-white col-span-5 row-start-2 row-end-2 border  border-black"></div>
    <div class="bg-white col-span-1 row-start-3 row-end-3 col-start-2  border-black"></div>
</div>
</div> -->

    <div class="grid gap-4 grid-cols-12 max-w-5xl mx-auto">
        <div class="col-span-8 flex flex-col gap-8">
            <x-info-window title="whoami" class="p-4" icon="user">
            <div class="prose prose-stone text-black">
                <p>
                    Software and aerospace engineer. Experienced in socket, 
                    systems, and scientific programming. Currently dipping my 
                    toes in Rust, Go, and Scheme while working on quantitative development 
                    and competitive programming.
                </p>
                <p>
                    I have spent more hours configuring DevOps and infrastructure than I'm willing
                    to admit -- check out the <a href="/projects/datacenter/index.html">"datacenter"</a>.
                </p>
                <p>
                    As you can see, I am not a front end developer.
                </p>
            </div>
            </x-info-window>

            {{-- Projects section --}}
            <x-info-window title="projects" class="p-4" icon="lightbulb">
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($projects as $p)
                        @include('_partials.card', [
                            'title' => $p->title,
                            'image' => $p->image,
                            'link' => $p->url,
                        ])
                    @endforeach
                </div>
            </x-info-window>

            {{-- Blog section --}}
            <x-info-window title="blog" class="p-4" icon="blog">
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($blog as $p)
                        @include('_partials.card', [
                            'title' => $p->title,
                            'image' => $p->image,
                            'link' => $p->url,
                        ])
                    @endforeach
                </div>
            </x-info-window>
        </div>
        <div class="col-span-4 flex flex-col gap-8">
            <x-terminal-window title="links" icon="link">
                {{-- ['text' => 'Home', 'newtab' => false, 'icon_type' => 'solid', 'icon' => 'home', 'link' => ''], --}}
                @php
                    $links = [
                        ['text' => 'GitHub', 'icon_type' => 'brands', 'icon' => 'github', 'link' => 'https://github.com/xbazzi'],
                        ['text' => 'LinkedIn', 'icon_type' => 'brands', 'icon' => 'linkedin', 'link' => 'https://linkedin.com/in/alexbazzi'],
                        ['text' => 'Gitea', 'icon_type' => 'brands', 'icon' => 'git-alt', 'link' => 'https://gitgud.foo'],
                        ['text' => 'Vikunja', 'icon_type' => 'solid', 'icon' => 'clipboard', 'link' => 'https://todo.dudeget.online'],
                        ['text' => 'NextCloud', 'icon_type' => 'solid', 'icon' => 'cloud', 'link' => 'https://cloud.dudeget.online'],
                        ['text' => 'Mattermost', 'icon_type' => 'solid', 'icon' => 'message', 'link' => 'https://chat.thegrind.dev'],
                    ];
                @endphp
                <div class="text-verde p-3">
                    <div class="flex flex-col gap-2 ">
                        @foreach ($links as $link)
                            @include('_partials.link', $link)
                        @endforeach
                        <a target='_blank' class="block" rel='noreferrer noopener' href='mailto:xander@xbazzi.com'>
                            <img class="h-auto" src="/assets/img/gifs/email_keyboard.gif">
                        </a>
                    </div>
                </div>

            </x-terminal-window>

            <x-terminal-window title="darknet.org -rss" icon="rss">
                <div class="text-xs p-4 text-verde rounded-md pl-1" id="rss-feed">Loading... Or is it?</div>
            </x-terminal-window>
        </div>
    </div>

    {{-- Footer --}}
    <!-- <div class="flex w-full h-auto">
        <img src="/assets/img/gifs/green_lights.gif" alt="lightspeed">
        <img src="/assets/img/gifs/green_lights.gif" alt="lightspeed">
    </div> -->
@endsection
