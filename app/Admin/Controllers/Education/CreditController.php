<?php
/**
 * Created by PhpStorm.
 * User: Sky
 * Date: 2017-06-09
 * Time: 0:17
 */

namespace App\Admin\Controllers\Education;
use App\Models\EduCredit;

use App\Models\ListUniversity;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CreditController
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

            $content->header('绩点列表');
            $content->description('');

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

            $content->header('编辑');
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
        return Admin::grid(EduCredit::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('课程名称');
            $grid->university()->name('所属学校');
            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(EduCredit::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('university_id','学校')->options(ListUniversity::pluck('name','id'));
            $form->url('website','官方网址');
            $form->textarea('function_list','功能');
            $form->textarea('function_content','功能详情');
            $form->date('new_term','开学日期');
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}