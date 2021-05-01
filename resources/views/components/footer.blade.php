<footer id="footer" class="footer mt-auto py-3" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">
<div class="container text-center">
    @php
      $email_contact = config('app.settings.email_contact_page');
    @endphp
    <span class="text-muted">&copy @php echo date("Y"); @endphp by {{ config('app.settings.copyright') }} <a class="mx-2" href="{{ route('imprint')}}">Impressum</a> @if($email_contact)<a class="mx-4" href="{{ route('contact') }}">Kontakt</a>@endif</span>
  </div>
</footer>