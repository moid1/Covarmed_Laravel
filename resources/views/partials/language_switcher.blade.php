{{-- <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
    @foreach($available_locales as $locale_name => $available_locale)
    @if($available_locale === $current_locale)
    <span class="ml-2 mr-2 text-gray-700">{{ $locale_name }}</span>
    @else
    <a class="ml-1 underline ml-2 mr-2" href="language/{{ $available_locale }}">
        <span>{{ $locale_name }}</span>
    </a>
    @endif
    @endforeach
</div> --}}

<div class="language-picker js-language-picker">
    {{-- <label for="language-picker-select">Select your language</label> --}}
    <select class="form-control" onchange="changeLanguage(this.value)" name="language-picker-select" id="language-picker-select">
        @foreach($available_locales as $locale_name => $available_locale)
        <option value="{{$available_locale}}" {{$available_locale==$current_locale ? 'selected' : '' }}>
            {{ $available_locale}}</option>
        @endforeach
    </select>
</div>

<script>
function changeLanguage(lang){
    window.location.href = "{{url('language/')}}/"+lang;
}
</script>