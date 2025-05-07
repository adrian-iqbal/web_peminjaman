<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Ruangan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RuanganResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RuanganResource\RelationManagers;
use Filament\Forms\Components\Section;

class RuanganResource extends Resource
{
    protected static ?string $model = Ruangan::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Informasi Ruangan';

    protected static ?string $modelLabel = 'Data Ruangan';

    protected static ?string $slug = 'informasi-ruangan';

    protected static ?string $navigationGroup = 'Manajemen Ruangan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Ruangan')
                    ->description('Masukkan Data Ruangan')
                    ->schema([
                        TextInput::make('nama_ruangan')
                            ->required()
                            ->unique(),
                        TextInput::make('nama_peminjam')
                            ->label('Penanggung Jawab')
                            ->required()
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('No'),
                TextColumn::make('nama_ruangan')
                    ->searchable(),
                TextColumn::make('nama_peminjam')
                    ->label('Nama Peminjam')
            ])
            ->striped()
            ->recordUrl(null)
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
        
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRuangans::route('/'),
            'create' => Pages\CreateRuangan::route('/create'),
            'edit' => Pages\EditRuangan::route('/{record}/edit'),
        ];
    }
}
