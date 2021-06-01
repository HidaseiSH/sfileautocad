<div>

    <div class="container">
        <div class="card-body">
            <div>
                <select wire:change="showInd" wire:model="year" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                    <option value="">Seleccione un año</option>
                    @foreach ($years as $y)
                        <option value="{{$y->year}}">{{$y->year}}</option>
                    @endforeach
                    @php
                        unset($y)
                    @endphp
                </select>
                @if ($year)
                    <select wire:change="showInd" wire:model="month" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                        <option value="">Seleccione un mes</option>
                        @foreach ($this->months as $m)
                            <option value="{{$m->month}}">{{$this->get_months($m->month - 1)}}</option>
                        @endforeach
                        @php
                            unset($m)
                        @endphp
                    </select>                    
                @endif

            </div>
        </div>
    </div>
    <div class="container mt-6 grid grid-cols-2 col-span-6">
        <div class="card">
            <canvas id="myBarChart" width="768" height="384" style="display: block; box-sizing: border-box; height: 384px; width: 768px;"></canvas>
        </div>
        <div class="card">
            <canvas id="myBarChart2" width="768" height="384" style="display: block; box-sizing: border-box; height: 384px; width: 768px;"></canvas>
        </div>
    </div>
    <div class="container mt-6 grid grid-cols-2 col-span-6">
        <div class="card">
            <canvas id="myBarChart3" width="768" height="384" style="display: block; box-sizing: border-box; height: 384px; width: 768px;"></canvas>
        </div>
    </div>

    @section('script')
        <script src="{{URL::asset('js/chart.js')}}"></script>
    @endsection
</div>
