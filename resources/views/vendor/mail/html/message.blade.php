@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
        <img align="center" alt="" src="{{URL::to('img/logo_japam.png')}}" style="max-width:400px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage blockDropTarget" id="dijit__Templated_0" widgetid="dijit__Templated_0">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} JAPAM Junta de Agua Potable y Alcantarillado Municipal, San Juan del Río, Qro.
        @endcomponent
    @endslot
@endcomponent
