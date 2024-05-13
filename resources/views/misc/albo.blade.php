<x-layouts.with-drawer>
    <x-slot name="style">
        <style>
            body {
                margin: 0;
                padding: 0;
                overflow: auto;
            }
        </style>
    </x-slot>

    <div class="pyro">
        <div class="before"></div>
        <div class="after"></div>
    </div>

    <div class="flex justify-center items-center h-screen">
        <div class="card shadow-xl">
            <figure class="shadow-xl bg-neutral text-base-100 flex justify-center">
                <img class="w-16" src="{{Vite::asset('resources/img/albo.png')}}" alt="corona d'alloro dorata">
                <figcaption class="title-font text-4xl">
                    Albo D'Oro
                </figcaption>
            </figure>
            <div class="card-body pt-0">
                <ul class="timeline">
                    <li>
                        <time class="timeline-start">2013</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-neutral">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">Alessio Fuganti</div>
                        <hr class="bg-neutral"/>
                    </li>
                    <li>
                        <hr class="bg-neutral"/>
                        <time class="timeline-start">2014</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-neutral">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">Luca Artesini</div>
                        <hr class="bg-neutral"/>
                    </li>
                    <li>
                        <hr class="bg-neutral"/>
                        <time class="timeline-start">2016</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-neutral">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">Stefano Valente</div>
                        <hr class="bg-neutral"/>
                    </li>
                    <li>
                        <hr class="bg-neutral"/>
                        <time class="timeline-start">2018</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-neutral">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">Giulio Delaini</div>
                        <hr class="bg-neutral"/>
                    </li>
                    <li>
                        <hr class="bg-neutral"/>
                        <time class="timeline-start">2021</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-neutral">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">Matteo Caeran</div>
                        <hr class="bg-neutral"/>
                    </li>
                    <li>
                        <hr class="bg-neutral"/>
                        <time class="timeline-start">2022</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-neutral">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">Qualcuno</div>
                        <hr/>
                    </li>
                    <li>
                        <hr/>
                        <time class="timeline-start">2024</time>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box">???</div>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</x-layouts.with-drawer>
