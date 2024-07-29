<?php

namespace App\Http\Controllers\Boilerplate;

use Illuminate\Http\Request;
use ReflectionException;

class DatatablesController
{
    /**
     * Rendering DataTable.
     *
     * @param  Request  $request
     * @param  string  $slug
     * @return mixed
     *
     * @throws ReflectionException
     */
    public function make(Request $request, string $slug)
    {
        if (! $request->ajax()) {
            abort(404);
        }

        return $this->getDatatable($slug)->make();
    }

    /**
     * Get DataTable class for the given slug.
     *
     * @param  string  $slug
     * @return false|mixed
     *
     * @throws ReflectionException
     */
    private function getDatatable(string $slug)
    {
        $datatable = app('boilerplate.datatables')->load(app_path('Datatables'))->getDatatable($slug);

        if (! $datatable) {
            abort(404);
        }

        return $datatable;
    }
}
