
@if ($message = Session::get('warning') || !empty($warningMsg))
<article class="message is-warning">
  <div class="message-header">
	  <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($warningMsg)? Session::get('warning'):$warningMsg !!}
  </div>
</article>
@endif

@if ($message = Session::get('danger') || !empty($dangerMsg))
<article class="message is-danger">
  <div class="message-header">
	  <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($dangerMsg)? Session::get('danger'):$dangerMsg !!}
  </div>
</article>
@endif

@if ($message = Session::get('success') || !empty($successMsg))
<article class="message is-success">
  <div class="message-header">
    <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($successMsg)? Session::get('success'):$successMsg !!}
  </div>
</article>
@endif

@if ($message = Session::get('info') || !empty($infoMsg))
<article class="message is-info">
  <div class="message-header">
    <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($infoMsg)? Session::get('info'):$infoMsg !!}
  </div>
</article>
@endif

@if ($message = Session::get('link') || !empty($linkMsg))
<article class="message is-link">
  <div class="message-header">
    <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($linkMsg)? Session::get('link'):$linkMsg !!}
  </div>
</article>
@endif

@if ($message = Session::get('dark') || !empty($darkMsg))
<article class="message is-link">
  <div class="message-header">
    <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($darkMsg)? Session::get('dark'):$darkMsg !!}
  </div>
</article>
@endif

@if ($message = Session::get('primary') || !empty($primaryMsg))
<article class="message is-primary">
  <div class="message-header">
	  <p></p>
    <button class="delete" aria-label="delete"></button>
  </div>
  <div class="message-body">
    {!! empty($primaryMsg)? Session::get('primary'):$primaryMsg !!}
  </div>
</article>
@endif
<script>
$(document).on('click','.message .delete',function(){
	console.log('closing');
	$(this).parents('.message').fadeOut(500);
});
</script>