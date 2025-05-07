<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Barang;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BarangDipinjam;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangDipinjamResource\Pages;
use App\Filament\Resources\BarangDipinjamResource\RelationManagers;

class BarangDipinjamResource extends Resource
{
    protected static ?string $model = BarangDipinjam::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

    protected static ?string $navigationGroup = 'Manajemen Barang';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Peminjaman Barang')
                    ->description('Isi data barang yang dipinjamkan dengan lengkap')
                    ->schema([
                        Select::make('barang_id')
                            ->relationship('barang', 'nama_barang')
                            ->required()
                            ->label('Nama Barang')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $barang = Barang::find($state);
                                if ($barang) {
                                    $set('kode_barang', $barang->kode_barang);
                                } else {
                                    $set('kode_barang', null);
                                }
                            }),
                        TextInput::make('kode_barang')
                            ->label('Kode Barang')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Select::make('ruangan_id')
                            ->relationship('ruangan', 'nama_ruangan')
                            ->required()
                            ->label('Nama Ruangan'),
                        DatePicker::make('tanggal_pinjam')
                            ->minDate(now()->format('Y-m-d'))
                            ->label('Tanggal Pinjam')
                            ->required(),
                        Textarea::make('keterangan')
                            ->required()
                            ->label('Keterangan')
                            ->columnSpanFull()
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
                TextColumn::make('barang.nama_barang')
                    ->label('Nama Barang'),
                TextColumn::make('kode_barang')
                    ->label('Kode Barang'),
                TextColumn::make('ruangan.nama_ruangan')
                    ->label('Nama Ruangan'),
                TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Dipinjam')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d M Y')),
                TextColumn::make('keterangan')
                    ->label('Keterangan')
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
            'index' => Pages\ListBarangDipinjams::route('/'),
            'create' => Pages\CreateBarangDipinjam::route('/create'),
            'edit' => Pages\EditBarangDipinjam::route('/{record}/edit'),
        ];
    }
}
