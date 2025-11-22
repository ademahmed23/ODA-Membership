<?php

namespace App\Http\Livewire;

use App\Models\Organization\ArsiiLixaa;
use App\Models\ZoneMemberPay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class ArsiiLixaaTable extends PowerGridComponent
{
    use ActionButton;

    /*
    |--------------------------------------------------------------------------
    | Setup Features
    |--------------------------------------------------------------------------
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
    | Datasource
    |--------------------------------------------------------------------------
    */
    public function datasource(): Builder
    {
        return ArsiiLixaa::query();
    }

    /*
    |--------------------------------------------------------------------------
    | Relationship Search
    |--------------------------------------------------------------------------
    */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    | Add Columns
    |--------------------------------------------------------------------------
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('member_id')
            ->addColumn('organization_name')
            ->addColumn('organization_type')
            ->addColumn('woreda')
            ->addColumn('phone_number')
            ->addColumn('email')
            ->addColumn('payment_period')
            ->addColumn('member_started')
            ->addColumn('paymemt');
    }

    /*
    |--------------------------------------------------------------------------
    | Visible Columns
    |--------------------------------------------------------------------------
    */
    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->sortable()
                ->searchable(),

            Column::make('Organization ID', 'member_id')
                ->sortable()
                ->searchable(),

            Column::make('Organization Name', 'organization_name')
                ->sortable()
                ->searchable(),

            Column::make('Type', 'organization_type')
                ->sortable()
                ->searchable(),

            Column::make('Woreda/City', 'woreda')
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'phone_number')
                ->sortable()
                ->searchable(),

            Column::make('Email', 'email')
                ->sortable()
                ->searchable(),

            Column::make('Payment Period', 'payment_period')
                ->sortable()
                ->searchable(),

            Column::make('Started', 'member_started')
                ->sortable(),

            Column::make('Payment', 'paymemt')
                ->sortable()
                ->searchable(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Action Buttons
    |--------------------------------------------------------------------------
    */
    public function actions(): array
    {
        return [
            Button::make('edit', 'Edit')
                ->class('bx bx-edit-alt me-1')
                ->target('_self')
                ->route('arsii.edit', ['arsii' => 'id']),

            Button::make('destroy', 'Delete')
                ->class('bx bx-trash me-1')
                ->target('_self')
                ->route('arsii.destroy', ['arsii' => 'id'])
                ->method('delete'),

            Button::make('paid', 'Paid')
                ->class('bx bx-money me-1 text-success border border-success rounded'),

            Button::make('pay', 'Pay')
                ->class('bx bx-money me-1')
                ->target('_self')
                ->route('arsii.pay', ['arsii' => 'id']),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Action Rules
    |--------------------------------------------------------------------------
    */
    public function actionRules(): array
    {
        return [
            Rule::button('edit')
                ->when(fn () => Auth::user()->cannot('arsii-edit'))
                ->hide(),

            Rule::button('delete')
                ->when(fn () => Auth::user()->cannot('arsii-delete'))
                ->hide(),

            // Hide "Pay" if already paid this month
            Rule::button('pay')
                ->when(fn ($arsii) => 
                    ZoneMemberPay::where('member_id', $arsii->id)
                        ->where('model', 'arsii')
                        ->whereMonth('date', now()->month)
                        ->whereYear('date', now()->year)
                        ->exists()
                )
                ->hide(),

            // Show "Paid" only when payment exists
            Rule::button('paid')
                ->when(fn ($arsii) => 
                    !ZoneMemberPay::where('member_id', $arsii->id)
                        ->where('model', 'arsii')
                        ->whereMonth('date', now()->month)
                        ->whereYear('date', now()->year)
                        ->exists()
                )
                ->hide(),
        ];
    }
}
