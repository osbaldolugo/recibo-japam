<!-- begin #sidebar -->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">

        @if(auth('appuser')->check())
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="{!!url('img/user.png') !!}" alt="" /></a>
                </div>
                <div class="info">
                    @if(Auth::guard('appuser')->user())
                        {!! Auth::guard('appuser')->user()->people->name !!}
                        <small>{!! Auth::guard('appuser')->user()->email !!}</small>
                    @endif
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->
        @endif

        <!-- begin sidebar nav -->
        <ul class="nav">
               @include('layouts.app-user-menu')

        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->