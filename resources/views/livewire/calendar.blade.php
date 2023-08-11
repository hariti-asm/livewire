<div>
    <h1>{{ $month }} - {{ $year }}</h1>

    <div class="grid grid-cols-7 gap-2  bg-blue-400 text-center mt-3">
      <div>MON</div>
      <div>TU</div>
      <div>WED</div>
      <div>THUR</div>
      <div>FR</div>
      <div>STU</div>
      <div>SUN</div>
    </div>

    <div class="grid grid-cols-7 gap-2  bg-blue-400">
      @foreach ($days as $day)
        @if(!empty($day))
          <div class="aspect-square  flex items-center justify-center bg-green-300">
            {{ $day }}
          </div>
        @else
          <div class="aspect-square  flex items-center justify-center bg-gray-200">
            {{ $day }}
          </div>
        @endif
      @endforeach
    </div>
  </div>
