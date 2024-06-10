<div
    x-data="{
        startDate: new Date('{{$date}}'.replace(' ', 'T')).getTime(),
        countdown: 0,
        setDiff() { this.countdown = this.startDate - new Date().getTime() },
        init() {
            this.setDiff()
            let x = setInterval(() => {
                this.setDiff()
                if(this.countdown < 0) {
                    clearInterval(x)
                    this.countdown = 0
                }
            }, 1000)
        }
    }"
    class="grid grid-flow-col gap-5 text-center auto-cols-max"
>
    <x-partials.countdown.page :bgColor="$bgColor ?? 'bg-accent/30'" value="Math.floor(countdown / (1000 * 60 * 60 * 24))" text="days" />
    <x-partials.countdown.page :bgColor="$bgColor ?? 'bg-accent/30'" value="Math.floor((countdown % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))" text="hours" />
    <x-partials.countdown.page :bgColor="$bgColor ?? 'bg-accent/30'" value="Math.floor((countdown % (1000 * 60 * 60)) / (1000 * 60))" text="min" />
    <x-partials.countdown.page :bgColor="$bgColor ?? 'bg-accent/30'" value="Math.floor((countdown % (1000 * 60)) / 1000)" text="sec" />
</div>
