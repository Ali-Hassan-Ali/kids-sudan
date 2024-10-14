@if($buttons->contains('update') && !empty($permissions['update']))
    <a href="{{ route($baseRoute . '.edit', $model->id) }}" class="btn btn-warning btn-sm">
        <i class="fa fa-edit"></i> @lang('admin.global.edit')
    </a>
@endif

@if($buttons->contains('delete') && !empty($permissions['delete']))
    <form action="{{ route($baseRoute . '.destroy', $model->id) }}" method="POST" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm delete">
            <i class="fa fa-trash"></i> @lang('admin.global.delete')
        </button>
    </form>
@endif

@if($buttons->contains('show') && !empty($permissions['show']))
    <a href="{{ route($baseRoute . '.show', $model->id) }}" class="btn btn-info btn-sm">
        <i class="fa fa-eye"></i> @lang('admin.global.show')
    </a>
@endif