<?php

namespace App\Base\Controllers\Web;

use App\Base\Services\SingletonAuthPermissions;
use App\Base\Traits\Views\Path;
use App\Base\Traits\Views\Variable;
use App\Base\Traits\Custom\ResizableImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use App\Base\Traits\Model\FilterSort;

class Controller extends \App\Http\Controllers\Controller
{
    use Path, Variable, ResizableImageTrait;

    protected $request;
    protected $model;
    protected $queryItem;
    protected $hasDelete;
    protected $hasCreate;
    protected $hasPdf;
    protected $view_path;

    /**
     * the view file namespace
     *
     * @var string
     */
    protected $namespace = 'core#base';

    /**
     * the directory that will contain the views files
     *
     * @var string
     */
    protected $directory;

    /**
     * the full path to the view directory
     *
     * @var string
     */
    protected $path;

    /**
     * init
     *
     * @codeCoverageIgnore
     * @return void
     */
    public function __construct(
        FormRequest $request,
        Model $model,
        $view_path = null,
        $queryItem = [],
        $hasDelete = false,
        $hasCreate = true,
        $hasPdf = false,

    ) {
        $this->request = $request;
        $this->model = $model;
        $this->queryItem = $queryItem;
        $this->hasDelete = $hasDelete;
        $this->hasCreate = $hasCreate;
        $this->hasPdf = $hasPdf;
        $this->view_path = $view_path;
        $this->setupView();
        view()->share('global', $this->globalVariables());
    }

    public function can($route)
    {
        $action = 'web.v1.admin.' . $route;
        $singleton_obj = SingletonAuthPermissions::getInstance();
        if (stripos($singleton_obj->getAllWebPermissions(), $action) !== false) {
            if (stripos($singleton_obj->getWebAuthPermissions(), $action) == false) {
                return false;
            }
        }
        return true;
    }

    public function relations(): array
    {
        return [];
    }

    public function indexActions(): array
    {
        return $this->model->MyColumns();
    }

    public function filter()
    {
        $filters  = [];
        foreach ($this->model->filterColumns() as $key => $value) {
            if (is_object($value)) {
                $filters[] = $value->getName();
            } else {
                $filters[] = $value;
            }
        }
        return $filters;
    }

    public function bearerToken()
    {
        $header = request()->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    public function index()
    {
        $records = $this->model;
        if (in_array(FilterSort::class, class_uses_recursive($this->model))) {
            $records = $records->setFilters()->defaultSort('-created_at');
        } else {
            $records = $this->model->where($this->queryItem)->latest();
        }

        if (!empty($this->relations())) {
            $records = $records->with(...$this->relations());
        }

        $create_route = $this->hasCreate ? str_replace('index', 'create', Request::route()->getName()) : null;
        $pdf_route = $this->hasPdf ? str_replace('index', 'pdf', Request::route()->getName()) : null;
        $edit_route = str_replace('index', 'edit', Request::route()->getName());
        $show_route = str_replace('index', 'show', Request::route()->getName());
        $destroy_route = str_replace('index', 'destroy', Request::route()->getName());
        $records = $records->paginate($this->request->per_page ?? 10);

        return view($this->view_path . __FUNCTION__, compact('records', 'show_route', 'create_route', 'pdf_route', 'edit_route', 'destroy_route'));
    }

    public function create()
    {
        $store_route = str_replace('create', 'store', Request::route()->getName());
        return view($this->view_path . __FUNCTION__, compact('store_route'));
    }

    public function store()
    {
        $record = $this->model->create(Arr::except($this->request->validated(), ['image', 'media']));

        if ($this->request->has('image') && !is_null($this->request->image)) {
            $record->image = $this->uploadImage($this->request->image);
            $record->save();
        }

        $record->fresh();

        if (!empty($this->relations())) {
            $record = $record->load(...$this->relations());
        }

        $this->model = $record;

        $index_route = str_replace('create', 'index', Request::route()->getName());
        return redirect()->route($index_route)->with('success', __('admin.successfully_added'));
    }


    public function show($id)
    {
        $record = $this->model->findOrFail($id);

        return view($this->view_path . __FUNCTION__, compact('record'));
    }


    public function edit($id)
    {
        $record = $this->model->findOrFail($id);
        $update_route = str_replace('edit', 'update', Request::route()->getName());
        return view($this->view_path . __FUNCTION__, compact('record', 'update_route'));
    }

    public function update($id)
    {
        $model = $this->model->findOrFail($id);
        $model->update(Arr::except($this->request->validated(), ['image']));

        if ($this->request->has('image') && !is_null($this->request->image)) {
            $model->image = $this->updateImage($this->request->image, $model->image);
            $model->save();
        }

        if (!empty($this->relations())) {
            $model = $model->load(...$this->relations());
        }
        $this->model = $model;

        $index_route = str_replace('update', 'index', Request::route()->getName());
        return redirect()->route($index_route)->with('success', __('admin.successfully_updated'));
    }

    public function destroy($id)
    {
        if ($this->hasDelete) {
            $model = $this->model->findOrFail($id);

            foreach ($this->model->deleteRelations() as $key) {
                if ($model->$key()->count() > 0)
                    return response()->json([
                        'status'  => 0,
                        'message' => __('admin.delete_is_not_allowed_due_to_related_records'),
                        'id'      => $id
                    ]);
            }

            if ($model->image) {
                $this->deleteImage($model->image);
            }

            $model->delete();

            return response()->json([
                'status'  => 1,
                'message' => __('admin.successfully_deleted'),
                'id'      => $id
            ]);
        } else {
            return response()->json([
                'status'  => 0,
                'message' => __('admin.delete_is_not_allowed'),
                'id'      => $id
            ]);
        }
    }

    public function toggleBoolean($id, $action)
    {
        $record = $this->model->findOrFail($id);
        if (toggleBoolean($record, $action))
            return response()->json(['status' => 'success']);

        return response()->json(['status' => 'fail']);
    }

    public function generatePDF()
    {
        $view = $this->model->getTable();
        $data = $this->model->paginate(10);
        $pdf = \PDF::loadView('admin.' . $view . '.products-pdf', compact('data'));

        return $pdf->download($view . '.pdf');
    }
}
