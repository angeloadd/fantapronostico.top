<div class="flex flex-col p-2 bg-base-300 rounded-box text-base-content">
    <span class="countdown font-mono text-3xl sm:text-5xl">
      <span x-bind:style="{ '--value' : {{$value}} }"></span>
    </span>
    {{$text}}
</div>
