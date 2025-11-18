<?php

namespace App\Http\Livewire;

use App\Models\News;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class NewsTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
     * PowerGrid datasource.
     *
     * @return Builder<\App\Models\News>
     */
    public function datasource(): Builder
    {
        return News::query();
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    | ❗ IMPORTANT: When using closures, you must escape any value coming from
    |    the database using the `e()` Laravel Helper function.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('title')

            /** Example of custom column using a closure **/
            ->addColumn('title_lower', function (News $model) {
                return strtolower(e($model->title));
            })
            //show only 75 characters from the content
            ->addColumn('content', function (News $model) {
                return substr(e($model->content), 0, 75);
            })
            //display the image
            ->addColumn('image', function (News $model) {
                return '<img src="' . e($model->image) . '" width="60" height="60" />';
            })
            //make the document downloadable and display the name
            ->addColumn('document', function (News $model) {
                return '<a href="' . e($model->document) . '" download>' . basename(e($model->document)) . '</a>';
            })
            //display the video in a modal
            ->addColumn('video', function (News $model) {
                return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#videoModal">
                            Video
                        </button>
                        <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="videoModalLabel">Video</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <video width="100%" height="100%" controls>
                                            <source src="' . e($model->video) . '" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
            });

        // ->addColumn('video');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

    /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            Column::make('TITLE', 'title')
                ->sortable()
                ->searchable(),

            Column::make('CONTENT', 'content')
                ->sortable()
                ->searchable(),

            Column::make('IMAGE', 'image')
                ->sortable()
                ->searchable(),

            Column::make('DOCUMENT', 'document')
                ->sortable()
                ->searchable(),

            Column::make('VIDEO', 'video')
                ->sortable()
                ->searchable(),



        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

    /**
     * PowerGrid News Action Buttons.
     *
     * @return array<int, Button>
     */

    public function actions(): array
    {
        return [
            Button::make('edit', 'Edit')
                ->class('bx bx-edit-alt me-1')
                ->target('_self')
                ->route('news.edit', ['news' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('bx bx-trash me-1')
                ->target('_self')
                ->route('news.destroy', ['news' => 'id'])
                ->method('delete')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

    /**
     * PowerGrid News Action Rules.
     *
     * @return array<int, RuleActions>
     */

    public function actionRules(): array
    {
        return [

            //Hide button edit for ID 1
            //Rule::button('edit')
            //  ->when(fn($news) => $news->id === 1)
            //->hide(),
            Rule::button('edit')
                ->when(fn () => Auth::user()->cannot('honorable-edit'))
                ->hide(),

            Rule::button('delete')
                ->when(fn () => Auth::user()->cannot('honorable-delete'))
                ->hide(),
        ];
    }
}
