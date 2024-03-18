<div class="flex items-center justify-end space-x-1 mx-2">
    <input
            id="themeModeToggle"
            type="checkbox"
            class="toggle"
            x-bind:checked="$store.theme.isDarkMode()"
            x-on:change="$store.theme.toggle()"
    />
    <label for="themeModeToggle" class="text-xl" x-data x-text="$store.theme.getIcon()"></label>
</div>
