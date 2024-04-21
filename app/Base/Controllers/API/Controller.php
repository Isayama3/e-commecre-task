<?php

namespace App\Base\Controllers\API;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Base\Traits\Model\FilterSort;
use App\Base\Resources\SimpleResource;
use Illuminate\Database\Eloquent\Model;
use App\Base\Traits\Request\SendRequest;
use App\Base\Traits\Response\SendResponse;
use Illuminate\Foundation\Http\FormRequest;
use App\Base\Traits\Custom\ResizableImageTrait;
use App\Http\Controllers\Controller as LaravelController;

class Controller extends LaravelController
{
    use SendResponse, SendRequest, ResizableImageTrait;

    /**
     * the request
     *
     * @var FormRequest
     */
    protected $request;

    /**
     * the eloquent model
     *
     * @var Model
     */
    protected $model;

    /**
     * the eloquent API resource
     *
     * @var string
     */
    protected $resource;
    protected $queryItem;
    protected $hasDelete;

    /**
     * Init.
     *
     * @codeCoverageIgnore
     * @param FormRequest $request
     * @param Model       $model
     * @param string      $resource
     * @return void
     */

    public function __construct(
        FormRequest $request,
        Model $model,
        $resource,
        $queryItem = [],
        $hasDelete = false,
    ) {
        $this->request = $request;
        $this->model = $model;
        $this->resource = $resource;
        $this->queryItem = $queryItem;
        $this->hasDelete = $hasDelete;
    }

    public function customWhen(): array
    {
        return [
            'condition' => false,
            'callback' => function ($q) {
            },
        ];
    }

    public function relations(): array
    {
        return [];
    }

    public function filter()
    {

        $filters  = [];
        foreach ($this->model->filterColumns() as $key => $value) {
            if (is_object($value)) {
                $column = $value->getName();
            } else {
                $column = $value;
            }
            $words = [
                '_id',
                'id',
                'password',
                'vcode',
                'deleted_at',
                'status',
                'state',
                'active',
                'get_',
                'donation',
                'sensor',
                'is_',
                'has_',
            ];
            $guard = true;
            foreach ($words as $word) {
                if (Str::contains($column, $word)) {
                    $guard = false;
                    break;
                }
            }
            if ($guard) {
                $filters[] = $column;
            }
        }
        return $filters;
    }

    public function index()
    {
        $record = $this->model;

        if (in_array(FilterSort::class, class_uses_recursive($this->model))) {
            $sort_column = method_exists($this->model, 'customSortColumn') ? $this->model->customSortColumn() : '-created_at';
            $record = $record->setFilters()->defaultSort($sort_column);
        } else {
            $record = $this->model->where($this->queryItem)->latest();
        }

        if (!empty($this->relations())) {
            $record = $record->with(...$this->relations());
        }

        $record = $record->when($this->customWhen()['condition'], $this->customWhen()['callback']);

        $record = $record->paginate($this->request->per_page ?? 10);

        return $this->sendResponse(
            $this->resource::collection($record),
            withmeta: true,
        );
    }

    public function list()
    {
        $record = $this->model;
        if (!empty($this->indexExceptIds())) {
            $record = $record->whereNotIn('id', $this->indexExceptIds());
        }
        $record = $record->take(3000)->get(['id', 'name']);
        return $this->sendResponse(SimpleResource::collection($record));
    }

    public function store()
    {
        $record = $this->model->create(Arr::except($this->request->validated(), ['image', 'media']));

        if ($this->request->has('image') && !is_null($this->request->image)) {
            $record->image = $this->uploadImage($this->request->image);
            $record->save();
        }

        $record->fresh();

        if (!empty($this->relations()))
            $record = $record->load(...$this->relations());

        $this->model = $record;
        return $this->sendResponse(
            new $this->resource($record),
            __('client.successfully_added'),
            true,
            201
        );
    }

    public function show($id)
    {
        if (!empty($this->relations())) {
            $record = $this->model->with(...$this->relations())->findOrFail($id);
        } else {
            $record = $this->model->findOrFail($id);
        }

        return $this->sendResponse(new $this->resource($record));
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

        return $this->sendResponse(new $this->resource($model), __('client.successfully_updated'));
    }

    public function destroy($id)
    {
        if ($this->hasDelete) {
            $model = $this->model->findOrFail($id);

            foreach ($this->model->deleteRelations() as $key) {
                if ($model->$key()->count() > 0)
                    return $this->ErrorMessage(__('admin.delete_is_not_allowed_due_to_related_records'));
            }

            if ($model->image) {
                $this->deleteImage($model->image);
            }

            $model->delete();

            return $this->SuccessMessage(__('client.successfully_deleted'));
        } else {
            return $this->ErrorMessage(__('client.delete_is_not_allowed'));
        }
    }
}
