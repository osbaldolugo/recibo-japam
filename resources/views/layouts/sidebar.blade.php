<!-- begin #sidebar layouts/sidebar-->
<div id="sidebar" class="sidebar">
    <!-- begin sidebar scrollbar -->
    <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
            <li class="nav-profile">
                <div class="image">
                    <a href="javascript:;"><img src="{!! empty(Auth::user()->url_image) ? url('img/man.png') : URL::to('../storage/app/public/user/' . Auth::user()->url_image) !!}" alt="" /></a>
                </div>
                <div class="info">
                    @if(Auth::user())
                        {!! Auth::user()->name !!}
                        <small>{!! Auth::user()->email !!}</small>
                    @endif
                </div>
                <br/>
                <div class="row">
                    <button onclick="location.href = '{{ route("tickets.create") }}';" type="button" class="btn btn-sm btn-primary center-block"><i class="fa fa-plus"></i> Crear Ticket <i class="fa fa-ticket"></i></button>
                </div>
            </li>
        </ul>
        <!-- end sidebar user -->

        <!-- begin sidebar navegatore -->
        <ul class="nav">
            @include('layouts.menu')
        </ul>
        <!-- end sidebar nav -->
    </div>
    <!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end #sidebar -->