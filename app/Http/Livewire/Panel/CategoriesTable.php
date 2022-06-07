<?php

namespace App\Http\Livewire\Panel;

use Modules\Blog\Entities\Category;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class CategoriesTable extends LivewireDatatable
{
    public $model = Category::class;

    public function columns()
    {
        return [
            // NumberColumn::name('id')->label(__('id')),
            
            Column::callback(['id', 'parent_id'], function ($id) {
                return Category::find($id)->title;
            })->label(__("Title")),
            
            Column::callback(['parent_id'], function ($id) {
                return Category::find($id)->title ?? '-';
            })->label(__('Parent')),
            // DateColumn::name('updated_at')->label(__('last update')),

            Column::callback(['id'], function ($id) {
                $btn = '<a href="'.route('module.blog.categories.edit', $id).'" class="btn btn-sm btn-secondary inline p-2">'.__('Edit').'</a>';
                return $btn;
            })->label('*'),

            Column::delete()
        ];
    }
}