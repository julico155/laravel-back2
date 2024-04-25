@if ($modal)
  <div class="modald">
    <div class="modald-contenido">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@yield('title','modal')</h5>
        </div>
        <div class="modal-body">
            @yield('body')
        </div>
        <div class="modal-footer">
            @yield('footer')
        </div>
      </div>
    </div>
  </div> 
  </div>  
@endif
