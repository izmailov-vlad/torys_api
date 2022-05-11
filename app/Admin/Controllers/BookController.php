<?php

namespace App\Admin\Controllers;

use App\Models\Book;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class BookController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Book';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Book());

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('image', __('Image'));
        $grid->column('author_id', __('Author id'));
        $grid->column('comment_id', __('Comment id'));
        $grid->column('book_url', __('Book url'));
        $grid->column('pages_count', __('Pages count'));
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
        $show = new Show(Book::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('author_id', __('Author id'));
        $show->field('image', __('Image'));
        $show->field('comment_id', __('Comment id'));
        $show->field('book_url', __('Book url'));
        $show->field('pages_count', __('Pages count'));
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
        $form = new Form(new Book());

        $form->text('title', __('Title'));
        $form->number('author_id', __('Author id'));
        $form->number('comment_id', __('Comment id'));
        $form->text('image', __('Image'));
        $form->text('book_url', __('Book url'));
        $form->number('pages_count', __('Pages count'));

        return $form;
    }
}
