<footer id="footer" class="footer mt-auto m-0 p-0" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">
  <div class="h-100 d-flex flex-md-row flex-column flex-nowrap justify-content-center align-items-center p-0 m-0">
      @php
        $email_contact = config('app.settings.email_contact_page');
      @endphp

      <a class="px-5 py-3" href="{{ route('imprint')}}" style="color: {{ config('app.settings.button_text_color') }};">{{ __('Imprint') }}</a> 
      <span class="px-5 py-3">&copy @php echo date("Y"); @endphp {{ __('by') }} {{ config('app.settings.copyright') }}</span>
      
      @if($email_contact)
        <a class="px-5 py-3" href="{{ route('contact') }}" style="color: {{ config('app.settings.button_text_color') }};">{{ __('Contact') }}</a>
      @endif
      
  </div>
</footer>