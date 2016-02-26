@extends('theme::layout.public')
@section('css')
    <link href="{{ asset('/css/default/space.css')}}" rel="stylesheet">
@endsection

@section('jumbotron')
    <header class="space-header">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <a class="text-left" href="{{ route('auth.space.index',['user_id'=>$userInfo->id]) }}"><img class="avatar-128" src="{{ route('website.image.avatar',['avatar_name'=>$userInfo->id.'_big'])}}" alt="{{ $userInfo->name }}"></a>
                </div>
                <div class="col-md-7">
                    <h2 class="space-header-name">{{ $userInfo->name }}</h2>
                    <div class="space-header-role"><i class="fa fa-user-secret"></i> {{ $userInfo->title }} , @if($userInfo->gender===1) <i class="fa fa-mars"></i> @elseif($userInfo->gender===2) <i class="fa fa-venus"></i> @else <i class="fa fa-genderless"></i> @endif </div>
                    <div class="space-header-desc mt-10"><p>{{ $userInfo->description }}</p>
                    </div>
                    <div class="space-header-social">
                        <span class="space-header-social-item"><i class="fa fa-map-marker"></i> {{ Area()->getName($userInfo->province) }} @if(Area()->getName($userInfo->province)!=Area()->getName($userInfo->city)) - {{ Area()->getName($userInfo->city) }} @endif</span>
                        <span class="space-header-social-item"><i class="fa fa-calendar"></i> 注册于 {{ $userInfo->created_at->toDateString() }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mt-10">
                        @if(Auth()->check() && Auth()->user()->id === $userInfo->id)
                            <a href="{{ route('auth.profile.base') }}" class="btn mr-10 btn-primary">编辑个人资料</a>
                        @else
                        @if(Auth()->check() && Auth()->user()->isFollowed(get_class($userInfo),$userInfo->id))
                            <button type="button" id="follow-button" class="btn mr-10 btn-success active" data-source_type = "user" data-source_id = "{{ $userInfo->id }}"  data-show_num="true"  data-toggle="tooltip" data-placement="right" title="" data-original-title="关注后将获得更新提醒">已关注</button>
                        @else
                            <button type="button" id="follow-button" class="btn mr-10 btn-success" data-source_type = "user" data-source_id = "{{ $userInfo->id }}"  data-show_num="true" data-toggle="tooltip" data-placement="right" title="" data-original-title="关注后将获得更新提醒">关注</button>
                        @endif
                        <a class="btn mr-10 btn-primary">私信</a>
                        {{--<a class="btn mr-10 btn-default">举报</a>--}}
                        @endif
                    </div>
                    <div class="space-header-info row mt-30">
                        <div class="col-md-4">
                            <a href="{{ route('auth.space.coins',['user_id'=>$userInfo->id]) }}"><span class="h3">{{ $userInfo->userData->coins }}</span><span>金币数</span></a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('auth.space.credits',['user_id'=>$userInfo->id]) }}"><span class="h3">{{ $userInfo->userData->credits }}</span></a>
                            <span>经验值</span>
                        </div>
                        <div class="col-md-4">
                            <span class="h3" id="follower-num">{{ $userInfo->userData->followers }}</span><span>个粉丝</span>
                        </div>
                    </div>
                    <div class="mt-10 border-top" style="color:#999;padding-top:10px; ">
                        <i class="fa fa-paw"></i> 主页被访问 {{ $userInfo->userData->views }} 次
                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection


@section('content')
    <div class="row mt-30">
        <div class="col-md-2">
            <ul class="nav nav-pills nav-stacked space-nav">
                @if(Auth()->check() && Auth()->user()->id === $userInfo->id)
                    <li @if(request()->route()->getName() == 'auth.space.index') class="active" @endif ><a href="{{ route('auth.space.index',['user_id'=>$userInfo->id]) }}">我的主页</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.answers') class="active" @endif ><a href="{{ route('auth.space.answers',['user_id'=>$userInfo->id]) }}">我的回答</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.questions') class="active" @endif ><a href="{{ route('auth.space.questions',['user_id'=>$userInfo->id]) }}">我的提问</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.articles') class="active" @endif ><a href="{{ route('auth.space.articles',['user_id'=>$userInfo->id]) }}">我的文章</a></li>
                    <li role="separator" class="divider"><a></a></li>
                    <li @if(request()->route()->getName() == 'auth.space.coins') class="active" @endif ><a href="{{ route('auth.space.coins',['user_id'=>$userInfo->id]) }}">我的金币</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.credits') class="active" @endif ><a href="{{ route('auth.space.credits',['user_id'=>$userInfo->id]) }}">我的经验</a></li>
                @else
                    <li @if(request()->route()->getName() == 'auth.space.index') class="active" @endif ><a href="{{ route('auth.space.index',['user_id'=>$userInfo->id]) }}">他的主页</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.answers') class="active" @endif ><a href="{{ route('auth.space.answers',['user_id'=>$userInfo->id]) }}">他的回答</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.questions') class="active" @endif ><a href="{{ route('auth.space.questions',['user_id'=>$userInfo->id]) }}">他的提问</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.articles') class="active" @endif ><a href="{{ route('auth.space.articles',['user_id'=>$userInfo->id]) }}">他的文章</a></li>
                    <li role="separator" class="divider"><a></a></li>
                    <li @if(request()->route()->getName() == 'auth.space.coins') class="active" @endif ><a href="{{ route('auth.space.coins',['user_id'=>$userInfo->id]) }}">他的金币</a></li>
                    <li @if(request()->route()->getName() == 'auth.space.credits') class="active" @endif ><a href="{{ route('auth.space.credits',['user_id'=>$userInfo->id]) }}">他的经验</a></li>
                @endif
            </ul>
        </div>
        <!-- Nav tabs -->
        <div class="col-md-10">
            @yield('space_content')
        </div>
    </div>
@endsection
