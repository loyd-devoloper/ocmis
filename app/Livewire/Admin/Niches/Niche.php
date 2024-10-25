<?php

namespace App\Livewire\Admin\Niches;

use Livewire\Component;
use Filament\Tables\Table;
use Livewire\Attributes\Title;

use Filament\Support\Colors\Color;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Niche extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Niche::query()->with(['buildingInfo', 'customerInfo', 'installments']))
            ->headerActions([
                Action::make('create')
                    ->label('Add Niche')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ScreenExtraLarge)

                    ->form([
                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2
                        ])->schema([
                            TextInput::make('niche_number')->numeric(),
                            Select::make('building_id')
                                ->label('Building')
                                ->options(\App\Models\Building::all()->pluck('name', 'id')),
                            TextInput::make('capacity')->numeric(),
                            Select::make('level')
                                ->options([
                                    'Level 1' => 'Level 1',
                                    'Level 2' => 'Level 2',
                                    'Level 3' => 'Level 3',
                                    'Level 4' => 'Level 4',
                                    'Level 5' => 'Level 5',
                                    'Level 6' => 'Level 6',
                                ]),
                            TextInput::make('price')->numeric(),
                            FileUpload::make('image')->directory('/niches/niche')->image()->previewable(false),
                            RichEditor::make('description')
                                ->required()
                                ->columnSpanFull()
                                ->toolbarButtons([

                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'underline',
                                    'undo',
                                ])
                        ])
                    ])
                    ->action(function ($data) {
                        $data['status_payment'] = \App\Enums\StatusEnum::NotPaid->value;
                        \App\Models\Niche::create($data);
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('id')->searchable(),
                ImageColumn::make('image')->width(50)->height(50),
                TextColumn::make('buildingInfo.name')->label('Buinding Name')->searchable(),
                TextColumn::make('niche_number'),
                TextColumn::make('capacity'),
                TextColumn::make('installments')

                ->listWithLineBreaks()
                ->limitList(3)
                ->expandableLimitedList()
                ->formatStateUsing(fn($state) => $state->status == \App\Enums\StatusEnum::NotPaid->value ? new HtmlString("<span class='monthlyDanger'>$state->price</span>") : new HtmlString("<span class='monthlySuccess'>$state->price</span>")),

                TextColumn::make('status'),
                TextColumn::make('customerInfo.username'),
                TextColumn::make('level'),
                TextColumn::make('payment_method'),
                TextColumn::make('payment_type'),

                TextColumn::make('price')->label('Niche Price'),
                TextColumn::make('price_checkout')->label('Total'),
                TextColumn::make('total_paid')->label('Total Paid'),

            ])

            ->actions([
                ActionGroup::make([
                    Action::make('x')
                        ->label('Pay Installment')
                        ->icon('heroicon-o-banknotes')
                        ->color(Color::Green)
                        ->form(function ($record) {

                            $arr = [];
                            $i = 1;
                            foreach ($record?->installments as $installment) {
                                $label = '';
                                if ($i == 1) {
                                    $label = 'First Month';
                                } elseif ($i == 2) {
                                    $label = 'Second Month';
                                } elseif ($i == 3) {
                                    $label = 'Third Month';
                                }
                                $arr[] =    Grid::make(5)->schema([
                                    Placeholder::make('dsasdad')->columnSpan(3)->label($label),
                                    \Filament\Forms\Components\Actions::make([

                                        \Filament\Forms\Components\Actions\Action::make($i.'comment')
                                            ->iconButton()
                                            ->extraAttributes(['title' => 'Add Comment'])
                                            ->icon('heroicon-o-check')
                                            ->label('add comment')
                                            ->color(Color::Green)

                                            ->action(function ($data, $record) use ($installment) {
                                               $installment->update(['status'=>\App\Enums\StatusEnum::Paid->value]);
                                                Notification::make()
                                                    ->title('Updated successfully')
                                                    ->success()
                                                    ->send();
                                            }),

                                        \Filament\Forms\Components\Actions\Action::make($i.'x')
                                            ->iconButton()
                                            ->extraAttributes(['title' => 'Add Comment'])
                                            ->icon('heroicon-o-x-mark')
                                            ->label('add comment')
                                            ->color(Color::Red)

                                            ->action(function ($data, $record) use ($installment) {
                                                $installment->update(['status'=>\App\Enums\StatusEnum::NotPaid->value]);
                                                Notification::make()
                                                    ->title('Updated successfully')
                                                    ->success()
                                                    ->send();
                                            })


                                    ])->columnSpan(2),

                                ]);
                                $i++;
                            }
                            return $arr;
                        })->hidden(fn($record) => $record->payment_type == 'Installment' ? false : true),
                    Action::make('approved')
                        ->color(Color::Green)->icon('heroicon-o-check')

                        ->action(function ($record) {
                            if ($record->payment_method == 'Cash' && $record->status == 'Pending' && $record->payment_type == 'Full') {
                                $record->update(['status' => 'Occupied', 'total_paid' => $record->price_checkout]);
                            } else {
                                $record->update(['status' => 'Occupied', 'total_paid' => 10000]);
                            }
                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        })->hidden(fn($record) => $record?->status == 'Occupied' || $record?->status == 'Available' ? true : false),
                    ViewAction::make('example')
                        ->form([
                            ViewField::make('rating')->view('livewire.customer.niche.items')


                        ])->hidden(fn($record) => !!$record->customer_id ? false : true),
                    EditAction::make('edit')

                        ->color(Color::Green)
                        ->modalWidth(MaxWidth::ExtraLarge)
                        ->form([
                            Grid::make([
                                'default' => 2,
                                'sm' => 1,
                                'md' => 2
                            ])->schema([
                                TextInput::make('niche_number')->numeric(),
                                Select::make('building_id')
                                    ->label('Building')
                                    ->options(\App\Models\Building::all()->pluck('name', 'id')),
                                TextInput::make('capacity')->numeric(),
                                Select::make('level')
                                    ->options([
                                        'Level 1' => 'Level 1',
                                        'Level 2' => 'Level 2',
                                        'Level 3' => 'Level 3',
                                        'Level 4' => 'Level 4',
                                        'Level 5' => 'Level 5',
                                        'Level 6' => 'Level 6',
                                    ]),

                                TextInput::make('price')->numeric(),
                                FileUpload::make('image')->directory('/niches/niche')->image()->previewable(false),
                                Select::make('status')
                                    ->options([
                                        'Available' => 'Available',
                                        'Pending' => 'Pending',
                                        'Occupied' => 'Occupied',

                                    ])->columnSpanFull(),
                                RichEditor::make('description')->columnSpanFull()
                                    ->toolbarButtons([
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                            ])
                        ])
                        ->action(function ($data, $record) {
                            $record->update($data);
                            Notification::make()
                                ->title('Updated successfully')
                                ->success()
                                ->send();
                        }),
                    DeleteAction::make()
                ])

            ])
        ;
    }
    #[Title('Niche')]
    public function render()
    {
        return view('livewire.admin.niches.niche');
    }
}
