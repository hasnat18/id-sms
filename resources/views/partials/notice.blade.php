@isset($notice)
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <strong>{{$notice->title}}!</strong> {{$notice->notice}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endisset
