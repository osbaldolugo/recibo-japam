{{-- Load the css file to the header --}}
<script type="text/javascript">
    function loadCSS(filename) {
        var file = document.createElement("link");
        file.setAttribute("rel", "stylesheet");
        file.setAttribute("type", "text/css");
        file.setAttribute("href", filename);

        if (typeof file !== "undefined"){
            document.getElementsByTagName("head")[0].appendChild(file)
        }
    }
    loadCSS({!! '"'.asset('//cdn.datatables.net/v/bs/dt-' . App\Http\Helpers\Cdn::DataTables . '/r-' . App\Http\Helpers\Cdn::DataTablesResponsive . '/datatables.min.css').'"' !!});
    loadCSS ({!! '"'.asset('https://cdnjs.cloudflare.com/ajax/libs/summernote/' . App\Http\Helpers\Cdn::Summernote . '/summernote.css').'"' !!});

</script>