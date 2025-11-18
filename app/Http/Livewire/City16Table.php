<?php

namespace App\Http\Livewire;

use App\Models\City16;
use App\Models\CityMemberPay;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class City16Table extends PowerGridComponent
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
     * @return Builder<\App\Models\City16>
     */
    public function datasource(): Builder
    {
        return City16::query();
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
            ->addColumn('first_name')

            /** Example of custom column using a closure **/
            ->addColumn('first_name_lower', function (City16 $model) {
                return strtolower(e($model->first_name));
            })

            ->addColumn('middle_name')
            ->addColumn('last_name')
            ->addColumn('gender')
            ->addColumn('age')
            ->addColumn('address')
            ->addColumn('contact_number')
            ->addColumn('email')
            ->addColumn('position')
            ->addColumn('membership_type')
            ->addColumn('membership_fee');
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

            Column::make('FIRST NAME', 'first_name')
                ->sortable()
                ->searchable(),

            Column::make('MIDDLE NAME', 'middle_name')
                ->sortable()
                ->searchable(),

            Column::make('LAST NAME', 'last_name')
                ->sortable()
                ->searchable(),

            Column::make('GENDER', 'gender')
                ->sortable()
                ->searchable(),

            Column::make('AGE', 'age')
                ->sortable()
                ->searchable(),

            Column::make('ADDRESS', 'address')
                ->sortable()
                ->searchable(),

            Column::make('CONTACT NUMBER', 'contact_number')
                ->sortable()
                ->searchable(),

            Column::make('EMAIL', 'email')
                ->sortable()
                ->searchable(),

            Column::make('POSITION', 'position')
                ->sortable()
                ->searchable(),

            Column::make('MEMBERSHIP TYPE', 'membership_type')
                ->sortable()
                ->searchable(),

            Column::make('MEMBERSHIP FEE', 'membership_fee')
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
     * PowerGrid City16 Action Buttons.
     *
     * @return array<int, Button>
     */


    public function actions(): array
    {
        return [
            Button::make('edit', 'Edit')
                ->class('bx bx-edit-alt me-1')

                ->target('_self')
                ->route('city16.edit', ['city16' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('bx bx-trash me-1')
                ->target('_self')
                ->route('city16.destroy', ['city16' => 'id'])
                ->method('delete'),
            Button::make('paid', 'Paid')
                ->class('bx bx-money me-1 text-success border border-success rounded'),
            Button::make('pay', 'Pay')
                ->class('bx bx-money me-1')
                ->target('_self')
                ->route('city16.pay', ['city16' => 'id'])
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
     * PowerGrid City16 Action Rules.
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
                ->when(fn () => Auth::user()->cannot('city16-edit'))
                ->hide(),

            Rule::button('delete')
                ->when(fn () => Auth::user()->cannot('city16-delete'))
                ->hide(),
            Rule::button('pay')
                ->when(fn ($city16) => CityMemberPay::where('member_id', $city16->id)->where('model', 'city16')->whereMonth(
                    'date',
                    now()->month
                )->whereYear('date', now()->year)->exists())
                ->hide(),

            Rule::button('paid')
                ->when(fn ($city16) => !CityMemberPay::where('member_id', $city16->id)->where('model', 'city16')->whereMonth(
                    'date',
                    now()->month
                )->whereYear('date', now()->year)->exists())
                ->hide(),

        ];
    }
}
