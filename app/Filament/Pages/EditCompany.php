<?php

namespace App\Filament\Pages;

use App\Models\Company;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Storage;

class EditCompany extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];


    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string $view = 'filament.pages.edit-company';
    protected static ?string $navigationGroup = 'Company Data';
    protected static ?string $navigationLabel = 'Settings';
    

    public function mount(): void
    {
        $company = Company::all()->first();
        $admin = User::find(1);
        $this->form->fill([
            'email_admin' => $admin->email,
            'logo' => $company->logo,
            'signature_image' => $company->signature_image,
            'name' => $company->name,
            'alamat' => $company->alamat,
            'no_telp' => $company->no_telp,
            'email' => $company->email
        ]);
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo')->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('app')
                    ->required(),
                FileUpload::make('signature_image')->label('Tanda Tangan')
                    ->image()
                    ->disk('public')
                    ->directory('app')
                    ->required(),
                TextInput::make('name')->label('Nama')
                    ->required(),
                TextInput::make('alamat')
                    ->required(),
                TextInput::make('no_telp')->label('Nomor Telephone')
                    ->required(),
                TextInput::make('email')->label('Email')
                    ->required(),
                TextInput::make('email_admin')->label('Email Admin Login')
                    ->required(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $company = Company::first();
        $data = $this->form->getState();
        
       
        if($company) {
            if($data['logo'] != null) {
                try {
                    $data = $this->form->getState();
                    User::where('id', 1)->update([
                        'email' => $data['email_admin']
                    ]);
                    Company::where('id', 1)->update([
                        'logo' => $data['logo'],
                        'name' => $data['name'],
                        'alamat' => $data['alamat'],
                        'no_telp' => $data['no_telp'],
                        'email' => $data['email'],
                        'signature_image' => $data['signature_image'],
                    ]);
                } catch (Halt $exception) {
                    return;
                }
            } else {
                Storage::disk('public')->delete($company->logo);
            }

            try {
                $data = $this->form->getState();
                Company::where('id', 1)->update([
                        'logo' => $data['logo'],
                        'name' => $data['name'],
                        'alamat' => $data['alamat'],
                        'no_telp' => $data['no_telp'],
                        'email' => $data['email'],
                        'signature_image' => $data['signature_image'],
                ]);
                User::where('id', 1)->update([
                    'email' => $data['email_admin']
                ]);
            } catch (Halt $exception) {
                return;
            }

            Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

           
        }
    }
}
