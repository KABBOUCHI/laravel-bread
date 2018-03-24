<?php namespace KABBOUCHI\Bread\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;


class BreadController extends Controller
{
    public $theme = "inspinia";

    public $name = "Bread";

    public $as = "bread.";

    /** @var Model $modelClass */
    public $modelClass;

    public $redirectTo = '/';

    public $tableFields = [
        'ID'   => 'id',
        'Name' => 'name',
    ];

    public $types = [
        'name' => 'text',
    ];

    public $createValidation = ['name' => 'required'];
    public $updateValidation = null;

    public $selects = [];
//    public $selects = [
//        'combat_sub_category_id' => 'categories'
//    ];
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        $model = $this->modelClass::all();

        $tableView = tableView($model)
            ->setTableClass('table table-striped table-hover');

        foreach ($this->getTableFields() as $key => $value)
            $tableView->column($key, $value);


        $tableView->column(function ($model) {
            return '<a class="btn-white btn btn-xs" href="' . route($this->as . 'edit', $model) . '">Edit</a> &nbsp;' .
                '<a class="btn-danger btn btn-xs" href="' . route($this->as . 'delete', $model) . '">Delete</a>';
        })->useDataTable();

        return view("bread::{$this->theme}.index", compact('tableView'))
            ->with('data', $this->data());
    }

    public function getTableFields()
    {
        return $this->tableFields;
    }

    protected function data()
    {
        return [
            'as'            => $this->as,
            'name'          => $this->name,
            'redirectTo'    => $this->redirectTo,
            'fillable'      => $this->types,
            'create_fields' => $this->getFields(),
            'update_fields' => $this->getFields(true),
            'selects'       => $this->getSelects()
        ];
    }

    public function getFields($update = false)
    {
        $fields = collect($update ? ($this->updateValidation ?? $this->createValidation) : $this->createValidation);

        $types = collect($this->types);

        return $fields->map(function ($value, $key) use ($types) {
            if ($types->has($key)) {
                if (is_array($value)) {
                    $value[] = $types->get($key);
                } else {
                    $value = [$value, $types->get($key)];
                }
            }

            return $value;
        });
    }

    private function getSelects()
    {
        $selects = [];
        collect($this->types)->each(function ($type, $key) use (&$selects) {
            if ($type == 'select') {
                if (isset($this->selects[$key])) {
                    $data = explode('|', $this->selects[$key]);
                    $method = $data[0];
                    $k = 'id';
                    $v = 'name';

                    if (isset($data[1])) {
                        $data = explode(',', $data[1]);
                        $k = $data[0];
                        $v = $data[1];
                    }

                    foreach ($this->$method() as $item) {
                        $selects[$key][$item[$k]] = $item[$v];
                    }
                }
            }
        });

        return $selects;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return view("bread::{$this->theme}.create")->with('data', $this->data());
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = request()->validate($this->createValidation);


        foreach ($this->createValidation as $key => $item) {
            $item = collect($item);

            if ($item->contains('image') && request()->hasFile($key)) {
                $data[$key] = $this->upload(request()->file($key), 'images/' . strtolower($this->name));
            }
        }

        $this->modelClass::create($data);

        return redirect($this->redirectTo);
    }

    function upload(UploadedFile $file, $path, $file_name = null)
    {
        if (!$file_name) {


            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);

            $file_name = str_slug($filename) . '-' . time() . '.' . $extension;
        }
        $path = $file->storePubliclyAs($path, $file_name, 'public');

        return $path;
    }

    /**
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($model)
    {
        $model = $this->getModel($model);

        return view("bread::{$this->theme}.edit", compact('model'))->with('data', $this->data());

    }

    private function getModel($model)
    {
        return $this->modelClass::findOrFail($model);
    }

    /**
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($model)
    {
        $model = $this->getModel($model);

        $data = request()->validate($this->updateValidation ?? $this->createValidation);

        foreach ($this->createValidation as $key => $item) {
            $item = collect($item);

            if ($item->contains('image') && request()->hasFile($key)) {
                $data[$key] = $this->upload(request()->file($key), 'images/' . strtolower($this->name));
            }
        }

        $model->update($data);

        return redirect($this->redirectTo);

    }

    /**
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($model)
    {
        $model = $this->getModel($model);

        return view("bread::{$this->theme}.delete", compact('model'))->with('data', $this->data());
    }

    /**
     * @param Model $model
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($model)
    {
        $model = $this->getModel($model);

        try {
            $model->delete();
        } catch (\Exception $e) {
        }

        return redirect($this->redirectTo);
    }
}