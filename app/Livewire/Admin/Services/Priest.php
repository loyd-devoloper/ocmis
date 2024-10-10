<?php

namespace App\Livewire\Admin\Services;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\PriestSchedule;
use Livewire\Attributes\Title;
use Filament\Actions\CreateAction;
use Filament\Support\Colors\Color;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Priest extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $schedule = [];
    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\Priest::query()->with('schedules'))
            ->headerActions([
                Action::make('create')
                    ->label('Add Category')
                    ->icon('heroicon-o-plus-circle')
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ScreenExtraLarge)

                    ->form([
                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2
                        ])->schema([
                            Group::make([
                                TextInput::make('name')->label('Name')->required(),
                                TextInput::make('contact')->required(),
                                TextInput::make('address')->required(),
                                Select::make('status')
                                    ->options([
                                        'Active' => 'Active',
                                        'InActive' => 'InActive',
                                    ])->default('1')->required(),
                            ]),
                            ViewField::make('rating')
                                ->view('livewire.admin.services.calendar')->statePath('schedule')->live()
                            //  ->afterStateUpdated(function (?string $state, ?string $old) {
                            //     dd($state);
                            // })
                        ])

                    ])
                    ->action(function ($data) {
                        $priest = \App\Models\Priest::create([
                            'name' => $data['name'],
                            'contact' => $data['contact'],
                            'address' => $data['address'],
                            'status' => $data['status'],
                        ]);
                        if ($priest) {

                            if (!!$data['schedule']) {
                                foreach (json_decode($data['schedule'], true) as $key => $value) {

                                    PriestSchedule::create([
                                        'priest_id' => $priest->id,
                                        'start_time' => $value['start'],
                                        'end_time' => $value['end'],
                                        'date' => $value['date'],
                                    ]);
                                }
                            }
                        }
                        Notification::make()
                            ->title('Created successfully')
                            ->success()
                            ->send();
                    })
            ])
            ->columns([
                TextColumn::make('id')->searchable(),

                TextColumn::make('name')->searchable(),
                TextColumn::make('contact'),
                TextColumn::make('address'),
                TextColumn::make('status'),
            ])

            ->actions([
                EditAction::make('edit')
                    ->label('Edit')
                    // ->mutateRecordDataUsing(function($data,$record){

                    // })
                    ->color(Color::Green)
                    ->modalWidth(MaxWidth::ScreenExtraLarge)

                    ->form([
                        Grid::make([
                            'default' => 2,
                            'sm' => 1,
                            'md' => 2
                        ])->schema([
                            Group::make([
                                TextInput::make('name')->label('Name')->required(),
                                TextInput::make('contact')->required(),
                                TextInput::make('address')->required(),
                                Select::make('status')
                                    ->options([
                                        'Active' => 'Active',
                                        'InActive' => 'InActive',
                                    ])->default('1')->required(),
                            ]),
                            ViewField::make('rating')
                                ->view('livewire.admin.services.calendar_edit')->statePath('schedule')->live()

                        ])

                    ])
                    ->action(function ($data,$record) {

                        $priest = $record->update([
                            'name' => $data['name'],
                            'contact' => $data['contact'],
                            'address' => $data['address'],
                            'status' => $data['status'],
                        ]);
                        if ($priest) {

                            if (!!$data['schedule']) {
                                PriestSchedule::where('priest_id',$record->id)->delete();
                                foreach (json_decode($data['schedule'], true) as $key => $value) {

                                    PriestSchedule::create([
                                        'priest_id' => $record->id,
                                        'start_time' => $value['start'],
                                        'end_time' => $value['end'],
                                        'date' => $value['date'],
                                    ]);
                                }
                            }
                        }
                        Notification::make()
                            ->title('Updated successfully')
                            ->success()
                            ->send();
                            $this->redirect(route('admin.services.priest'));
                    }),
                DeleteAction::make()
            ])
        ;
    }
    #[Title('Category')]
    public function render()
    {

        return view('livewire.admin.services.priest');
    }
}
