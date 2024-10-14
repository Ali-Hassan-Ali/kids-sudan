@if(!empty($buttons['update']) && !empty($permissions['update']))
    <a href="{{ route($bassRoute . '.edit', $model->id) }}" class="btn btn-warning btn-sm">
        <i class="fa fa-edit"></i> @lang('admin.global.edit')
    </a>
@endif

@if(!empty($buttons['delete']) && !empty($permissions['delete']))
    <form action="{{ route($bassRoute . '.destroy', $model->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm delete">
            <i class="fa fa-trash"></i> @lang('admin.global.delete')
        </button>
    </form>
@endif

@if(!empty($buttons['show']) && !empty($permissions['show']))
    <a href="{{ route($bassRoute . '.show', $model->id) }}" class="btn btn-info btn-sm">
        <i class="fa fa-eye"></i> @lang('admin.global.show')
    </a>
@endif
