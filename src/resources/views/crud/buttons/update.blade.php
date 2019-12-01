@if ($crud->hasAccess('update'))
	@if (!$crud->model->translationEnabled())

	<!-- Single edit button -->
	<a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') . "?" . http_build_query($crud->request->query()) }}" class="btn btn-sm btn-link"><i class="fa fa-edit"></i> {{ trans('backpack::crud.edit') }}</a>

	@else

	<!-- Edit button group -->
	<div class="btn-group">
	  <a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') . "?" . http_build_query($crud->request->query()) }}" class="btn btn-sm btn-link pr-0"><i class="fa fa-edit"></i> {{ trans('backpack::crud.edit') }}</a>
	  <a class="btn btn-sm btn-link dropdown-toggle text-primary pl-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    <span class="caret"></span>
	  </a>
	  <ul class="dropdown-menu dropdown-menu-right">
  	    <li class="dropdown-header">{{ trans('backpack::crud.edit_translations') }}:</li>
        <?php $querystring = $crud->request->query(); ?>
	  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
		  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?{{ http_build_query(array_merge($querystring, array("locale" => $key))) }}">{{ $locale }}</a>
	  	@endforeach
	  </ul>
	</div>

	@endif
@endif
