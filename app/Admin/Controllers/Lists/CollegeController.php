<?php

namespace App\Admin\Controllers\Lists;

use App\Models\ListCollege;

use App\Models\ListUniversity;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CollegeController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('学院列表');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(ListCollege::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('学院名称');
            $grid->university()->name('所属学校');
            $grid->created_at('创建时间');
            $grid->updated_at('上次修改时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ListCollege::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name','学院名称');
            $form->select('university_id','学校名称')->options(ListUniversity::pluck('name','id'));
            $form->display('created_at','创建时间');
            $form->display('updated_at','修改时间');
        });
    }
}
