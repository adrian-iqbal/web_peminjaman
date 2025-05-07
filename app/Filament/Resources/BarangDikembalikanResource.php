<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\BarangDipinjam;
use Filament\Resources\Resource;
use App\Models\BarangDikembalikan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BarangDikembalikanResource\Pages;
use App\Filament\Resources\BarangDikembalikanResource\RelationManagers;

class BarangDikembalikanResource extends Resource
{
    protected static ?string $model = BarangDikembalikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Manajemen Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pengembalian Barang')
                    ->description('Isi data pengembalian barang dengan lengkap')
                    ->schema([
                        Select::make('barang_id')
                            ->relationship('barang', 'nama_barang')
                            ->required()
                            ->label('Nama Barang')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $dipinjam = BarangDipinjam::where('barang_id', $state)->first();

                                if ($dipinjam) {
                                    $set('kode_barang', $dipinjam->kode_barang);
                                    $set('ruangan_id', $dipinjam->ruangan_id);
                                } else {
                                    $set('kode_barang', null);
                                    $set('ruangan_id', null);
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
                            ->label('Nama Ruangan')
                            ->disabled(fn() => true) // tetap tampil disabled di UI
                            ->dehydrated(fn($state) => filled($state)), // pastikan nilainya tetap disimpan
                        DatePicker::make('tanggal_dikembalikan')
                            ->minDate(now()->format('Y-m-d'))
                            ->label('Tanggal Dikembalikan')
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
                TextColumn::make('tanggal_dikembalikan')
                    ->label('Tanggal Dikembalikan')
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
            'index' => Pages\ListBarangDikembalikans::route('/'),
            'create' => Pages\CreateBarangDikembalikan::route('/create'),
            'edit' => Pages\EditBarangDikembalikan::route('/{record}/edit'),
        ];
    }
}
