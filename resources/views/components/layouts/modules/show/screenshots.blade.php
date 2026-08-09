@props(['module'])

<div class="relative">
    <nuvisaccounting-slider :screenshots="{{ json_encode($module->screenshots) }}" :arrow="true" :slider-view="5"></nuvisaccounting-slider>
</div>
