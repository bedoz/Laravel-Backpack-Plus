@if ($crud->get('reorder.enabled') && $crud->hasAccess('reorder'))
  <a href="{{ url($crud->route.'/reorder') . "?" . http_build_query($crud->request->query()) }}" class="btn btn-outline-primary" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-arrows"></i> {{ trans('backpack::crud.reorder') }} {{ $crud->entity_name_plural }}</span></a>
@endif
