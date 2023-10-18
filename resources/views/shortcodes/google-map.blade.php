<div class="@if($class) {{$class}} @else {{'google-map'}} @endif d-flex"
     style=" @if($style) {{$style}}; @else {{'height:400px;width: 100%; position: relative; text-align: right;'}} @endif ">
    <div class="google-map-wrapper w-100"
         style="@if($style) {{$style}} @else {{'height:400px; width: 100%; overflow: hidden; background: none!important;'}} @endif   ">
        <iframe style='height: 100%; width: 100%;'
                src="https://maps.google.com/maps?q={{ addslashes($address) }}%20&t=&z=13&ie=UTF8&iwloc=&output=embed"
                frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    </div>
</div>
