<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BarangResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangResource\RelationManagers;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Data Barang';

    protected static ?string $modelLabel = 'Data Barang';

    protected static ?string $navigationGroup = 'Manajemen Barang';

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'data-barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Barang')
                    ->description('Isi data barang dengan lengkap')
                    ->schema([
                        TextInput::make('kode_barang')
                            ->label('Kode Barang')
                            ->required()
                            ->unique(),
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required(),
                        TextInput::make('spesifikasi')
                            ->label('Spesifikasi')
                            ->required(),
                        TextInput::make('keterangan')
                            ->label('Keterangan')
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->required()
                            ->default('Tersedia')
                            ->options([
                                'Dipinjam' => 'Dipinjam',
                                'Tersedia' => 'Tersedia',
                            ]),
                        FileUpload::make('Gambar')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(3), // Kamu bisa ubah ke 2 kalau mau 2 kolom
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No.')
                    ->rowIndex(),
                TextColumn::make('kode_barang')
                    ->searchable()
                    ->label('Kode Barang'),
                TextColumn::make('nama_barang')
                    ->searchable()
                    ->label('Nama Barang'),
                TextColumn::make('spesifikasi')
                    ->searchable()
                    ->label('Spesifikasi'),
                TextColumn::make('keterangan')
                    ->label('Keterangan'),
                ImageColumn::make('gambar')
                    ->disk('public') // Pastikan kamu menambahkan disk
                    ->width(100) // Atur ukuran gambar
                    ->height(100),
                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'warning' => 'Dipinjam',
                        'success' => 'Tersedia',
                    ])
                    ->icon(fn(string $state): ?string => match ($state) {
                        'Dipinjam' => 'heroicon-o-arrow-path',
                        'Tersedia' => 'heroicon-o-check-circle',
                        default => null,
                    })
                    ->label('Status Barang')

            ])
            ->striped()
            ->recordUrl(null)
            ->filters([
                Tables\Filters\Filter::make('Dipinjam')
                    ->query(fn($query) => $query->where('status', 'Dipinjam')),
                Tables\Filters\Filter::make('Tersedia')
                    ->query(fn($query) => $query->where('status', 'Tersedia')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
            
        ];
    }
}
