<?php

namespace App\Admin\Controllers;

use App\Models\Comment;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CommentsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Comment';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Comment());

        $grid->column('id', __('Id'));
        $grid->column('user_id', __('User id'));
        $grid->column('book_id', __('Book id'));
        $grid->column('comment', __('Comment'));
        $grid->column('likes', __('Likes'));
        $grid->column('dislikes', __('Dislikes'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Comment::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_id', __('User id'));
        $show->field('book_id', __('Book id'));
        $show->field('comment', __('Comment'));
        $show->field('likes', __('Likes'));
        $show->field('dislikes', __('Dislikes'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Comment());

        $form->number('user_id', __('User id'));
        $form->number('book_id', __('Book id'));
        $form->textarea('comment', __('Comment'));
        $form->number('likes', __('Likes'));
        $form->number('dislikes', __('Dislikes'));

        return $form;
    }
}
