<footer id="footer" class="footer mt-auto m-0 p-0">
  <div class="h-100 d-flex flex-md-row flex-column flex-nowrap justify-content-center align-items-center p-0 m-0">
      @php
        $email_contact = config('app.settings.email_contact_page');
      @endphp

      <a class="px-5 py-3" href="{{ route('imprint')}}">Impressum</a> 
      <span class="px-5 py-3">&copy @php echo date("Y"); @endphp by {{ config('app.settings.copyright') }}</span>
      
      @if($email_contact)
        <a class="px-5 py-3" href="{{ route('contact') }}">Kontakt</a>
      @endif
      
  </div>
</footer>