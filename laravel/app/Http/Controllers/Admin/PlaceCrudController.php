<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlaceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Log;

/**
 * Class PlaceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Place::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/place');
        CRUD::setEntityNameStrings('place', 'places');
        $this->crud->denyAccess(['create', 'delete','update']);
        
        if (backpack_user()->hasPermissionTo('places.list')) {
            CRUD::allowAccess('list');
        }else{
            CRUD::denyAccess('list');
        }

        if (backpack_user()->hasPermissionTo('places.create')) {
            CRUD::allowAccess('create');
        }else{
            CRUD::denyAccess('create');
        }
        if (backpack_user()->hasPermissionTo('places.update')) {
            CRUD::allowAccess('update');
        }else{
            CRUD::denyAccess('update');
        }
        if (backpack_user()->hasPermissionTo('places.read')) {
            CRUD::allowAccess('read');
        }else{
            CRUD::denyAccess('read');
        }
        if (backpack_user()->hasPermissionTo('places.delete')) {
            CRUD::allowAccess('delete');
        }else{
            CRUD::denyAccess('delete');
        }
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name')->label(__('fields.name'));
        CRUD::column('description')->label(__('fields.description'));
        CRUD::column('latitude')->label(__('fields.latitude'));
        CRUD::column('longitude')->label(__('fields.longitude'));
        CRUD::column('file_id')->label(__('fields.file_id'));
        CRUD::column('category_id')->label(__('fields.category_id'));
        CRUD::column('visibility_id')->label(__('fields.visibility_id'));
        CRUD::column('author_id')->label(__('fields.author_id'));

    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PlaceRequest::class);

        CRUD::field('name');
        CRUD::field('description');
        CRUD::field('latitude');
        CRUD::field('longitude');
        CRUD::field('file_id');
        CRUD::field('category_id');
        CRUD::field('visibility_id');
        CRUD::field('author_id');

        /**
         * Fields hasPermissionTo be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
