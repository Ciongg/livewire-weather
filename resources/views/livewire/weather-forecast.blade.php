<!-- filepath: d:\Projects\test\test\resources\views\livewire\weather-forecast.blade.php -->
<div class="w-full max-w-5xl mx-auto">
    @if($loading)
        <div class="flex justify-center items-center h-40">
            <div class="animate-spin rounded-full h-10 w-10 border-2 border-gray-300 border-t-gray-600"></div>
        </div>
    @elseif($error)
        <div class="bg-red-50 text-red-600 p-3 rounded-md text-center">
            {{ $error }}
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7 gap-2">
            @foreach($weatherData as $day)
                <div class="bg-white rounded-lg border border-gray-100 p-6 transition-all duration-200 hover:bg-gray-200 hover:border-gray-300 hover:shadow-md cursor-pointer">
                    <div class="text-center">
                        <p class="text-sm font-medium text-gray-700">{{ date('D', strtotime($day['time'])) }}</p>
                        <p class="text-xs text-gray-500 mb-2">{{ date('M d', strtotime($day['time'])) }}</p>
                        <div class="text-6xl my-2">{{ $this->getWeatherIcon($day['weather_code'])['icon'] }}</div>
                        <p class="text-xs text-gray-600 truncate">{{ $this->getWeatherIcon($day['weather_code'])['description'] }}</p>
                    </div>
                    
                    <div class="flex justify-between items-center mt-3 mb-1">
                        <span class="text-xs text-gray-500">High</span>
                        <span class="text-sm font-medium text-gray-800">{{ $day['temperature_2m_max'] }}°</span>
                    </div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-xs text-gray-500">Low</span>
                        <span class="text-sm text-gray-600">{{ $day['temperature_2m_min'] }}°</span>
                    </div>
                    
                    <div class="flex justify-between text-xs mt-3 pt-3 border-t border-gray-100">
                        <div>
                            <span class="text-gray-500">Rain</span>
                            <span class="ml-1 text-gray-700">{{ $day['precipitation_probability_max'] }}%</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Wind</span>
                            <span class="ml-1 text-gray-700">{{ $day['wind_speed_10m_max'] }}km/h</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6 text-center text-xs text-gray-500">
            <p>All times are local. Data updated at {{ now()->format('g:i A') }}</p>
        </div>
    @endif
</div>