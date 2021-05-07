<div>

    <div class="container">
        <div class="card-body">
            <div class="pt-2 relative mx-auto text-gray-600">
                <input wire:model="search" class="w-full border-2 border-gray-300 bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:border-transparent"
                type="search" name="search" placeholder="Search">
            
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded absolute right-0 top-0 mt-2">
                    Buscar
                </button>
                @if ($search)
                    <ul class="absolute z-50 left-0 w-full bg-white mt-1 rounded-lg overflow-hidden">
                        @forelse ($this->results as $result)
                            <li  wire:click="send_data_bar_file('{{$result->my_description}}',{{$result->id}})" class="leading-10 px-5 text-sm cursor-pointer hover:bg-gray-300">
                                <span>{{ $result->my_description }}</span>
                            </li>
                        @empty
                            <li class="leading-10 px-5 text-sm cursor-pointer hover:bg-gray-300">
                                No hay ninguna coincidencia.
                            </li>
                        @endforelse
                    </ul>
                @endif
            </div>
            <div>
                <select wire:change="clear_select" wire:model="type" class=" border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                    <option value="month">Por Meses</option>
                    <option value="day">Por dias</option>
                </select>  
                <select wire:model="year" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                    <option value="">Seleccione un año</option>
                    @foreach ($years as $y)
                        <option value="{{$y->year}}">{{$y->year}}</option>
                    @endforeach
                    @php
                        unset($y)
                    @endphp
                </select>
                @if ($year && $type == 'day')
                    <select wire:model="month" class="border-gray-300 bg-white border rounded h-10 px-5 pr-16 text-sm focus:border-transparent">
                        <option value="">Seleccione un mes</option>
                        @foreach ($this->months as $m)
                            <option value="{{$m->month}}">{{$this->own_months($m->month)}}</option>
                        @endforeach
                        @php
                            unset($m)
                        @endphp
                    </select>                    
                @endif

            </div>
        </div>
    </div>
    <div class="container mt-6">
        <div class="card">
            <canvas id="myBarChart" width="768" height="384" style="display: block; box-sizing: border-box; height: 384px; width: 768px;"></canvas>
        </div>
    </div>

    @section('script')
        <script src="{{URL::asset('js/chart.js')}}"></script>
    @endsection
</div>
