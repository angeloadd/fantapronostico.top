<div class="text-base-100 flex flex-col p-2 {{$bgColor}} rounded-box fp2024-title font-bold">
    <span class="countdown text-sm sm:text-2xl">
      <span x-bind:style="{ '--value' : {{$value}} }"></span>
    </span>
    {{$text}}
</div>
