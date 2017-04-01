<?php

namespace App\Admin\Controllers\Lists;

use App\Http\Controllers\ChinaAreaController;
use App\Models\ListUniversity;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\ListProvince;
use App\Models\ListCity;
use App\Models\ListDistrict;

class UniversityController extends Controller
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

            $content->header('学校列表');
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

            $content->header('编辑学校');
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

            $content->header('创建学校');
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
        return Admin::grid(ListUniversity::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('学校名称')->sortable();
            $grid->district()->name('所在区')->sortable();
            $grid->longitude('经度');
            $grid->latitude('纬度');
            $grid->created_at('添加时间')->sortable();
            $grid->updated_at('最后更新时间')->sortable();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ListUniversity::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name','学校名称');
            $form->select('province_id','所在省')->options(ListProvince::pluck('name','id'))->load('city_id','/api/china-area/city');
            $form->select('city_id','所在市')->options(function($id){
                return ChinaAreaController::citylist($id);
            })->load('district_id','/api/china-area/district');
            $form->select('district_id','所在区')->options(function ($id) {
                return ChinaAreaController::districtList($id);
            });
            $form->text('longitude','经度');
            $form->text('latitude','纬度');
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
            $form->ignore(['province_id','city_id']);
        });
    }
}
