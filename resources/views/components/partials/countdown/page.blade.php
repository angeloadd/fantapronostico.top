<div class="flex flex-col p-2 bg-neutral rounded-box text-neutral-content">
    <span class="countdown font-mono text-5xl">
      <span x-bind:style="{ '--value' : {{$value}} }"></span>
    </span>
    {{$text}}
</div>
