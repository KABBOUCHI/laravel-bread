<?php namespace KABBOUCHI\Bread\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use KABBOUCHI\Bread\Http\BreadType;


/**
 * @property  Model modelClass
 */
class BreadController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        /** @var Model $model */
        $model = new $this->modelClass;
        if ($model->usesTimestamps()) {
            $model = $model->latest()->get();

        } else {
            $model = $model->all();
        }

        $tableView = tableView($model)
            ->setTableClass('table table-striped table-hover');

        if (count($this->getTableFields())) {
            foreach ($this->getTableFields() as $key => $value)
                $tableView->column($key, $value);
        } else {
            if ($model->count() > 0) {
                $array = $model->first()->toArray();

                foreach ($array as $key => $value) {
                    $tableView->column(str_replace('_', ' ', ucfirst($key)), $key);
                }
            }
        }

        $tableView->column(function ($model) {
            return '<a class="btn-white btn btn-xs" href="' . route($this->as . 'edit', $model) . '">Edit</a> &nbsp;' .
                '<a class="btn-danger btn btn-xs" href="' . route($this->as . 'delete', $model) . '">Delete</a>';
        })->paginate(10);

        return view("bread::{$this->theme}.index", compact('tableView'))
            ->with('data', $this->data());
    }

    protected function getTableFields()
    {
        return [];
    }

    protected function data()
    {
        $basename = explode('\\', basename($this->modelClass));
        $basename = end($basename);

        $data = [
            'as'         => strtolower(str_plural($basename)) . '.',
            'name'       => ucfirst($basename),
            'redirectTo' => route(strtolower(str_plural($basename)) . '.index'),
            'fillable'   => $this->getTableFields(),
            'fields'     => $this->getFields(),
        ];

        if (method_exists($this, 'getBreadOptions')) {
            $data = array_merge($data, $this->getBreadOptions());
        }

        return $data;
    }

    public function getFields($update = false)
    {
        $fields = $this->getFieldOptions();

        foreach ($fields as $key => &$field) {
            if (!isset($field['title'])) {
                $field['title'] = ucfirst(explode('_', $key)[0]);
            }

            if ($field['type'] == BreadType::IMAGE && !str_contains('image', $field['validation'])) {
                $field['validation'][] = 'image';
            }

            if (!isset($field['update_validation'])) {
                $field['update_validation'] = $field['validation'];
            }
        }

        return $fields;
    }

    public function getFieldOptions()
    {
        return [];
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
        $validation = collect($this->getFields())->map(function ($item) {
            return $item['validation'];
        })->toArray();

        $data = request()->validate($validation);

        foreach ($validation as $key => $item) {
            $item = collect($item);

            if ($item->contains('image') && request()->hasFile($key)) {
                $data[$key] = $this->upload(request()->file($key), 'images/' . strtolower($this->name));
            }
        }

        $this->modelClass::forceCreate($data);

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

        $validation = collect($this->getFields())->map(function ($item) {
            return $item['update_validation'];
        })->toArray();

        $data = request()->validate($validation);

        foreach ($validation as $key => $item) {
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

    public function __get($name)
    {
        if (method_exists($this, $name))
            return $this->{$name}();

        if (method_exists($this, 'get' . ucfirst($name)))
            return $this->{'get' . ucfirst($name)}();

        return $this->data()[$name];
    }

    protected function getTheme()
    {
        return config('bread.theme', 'inspinia');
    }
}