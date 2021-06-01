<div class="container">
    <div>
        <select wire:change="send_data_file" wire:model="year" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
            <option value="">Seleccione un año</option>
            @foreach ($years as $y)
                <option value="{{$y->year}}">{{$y->year}}</option>
            @endforeach
            @php
                unset($y)
            @endphp
        </select>
        @if ($year)
            <select wire:change="send_data_file" wire:model="month" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                <option value="">Seleccione un mes</option>
                @foreach ($this->months as $m)
                    <option value="{{$m->month}}">{{$this->own_months($m->month)}}</option>
                @endforeach
                @php
                    unset($m)
                @endphp
            </select>                    
        @endif
        {{-- <button wire:click="send_data_file" class="btn btn-primary">Mostrar</button> --}}
    </div>

    <div class="mt-6">
        <div class="card">
            <canvas id="myChart" width="768" height="384" style="display: block; box-sizing: border-box; height: 384px; width: 768px;"></canvas>
        </div>
    </div>

    @section('script')
        <script src="{{URL::asset('js/chart2.js')}}"></script>
    @endsection
</div>
