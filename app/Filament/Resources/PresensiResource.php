<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PresensiResource\Pages;
use App\Models\Presensi;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    
    protected static ?string $navigationLabel = 'Presensi';
    protected static ?string $modelLabel = 'Presensi';
    protected static ?string $pluralModelLabel = 'Presensi';
    protected static ?string $slug = 'presensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pegawai_id')
                    ->label('Pegawai')
                    ->options(Pegawai::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),
                Forms\Components\TimePicker::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->seconds(false),
                Forms\Components\TimePicker::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->seconds(false),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha' => 'Alpha',
                    ])
                    ->required()
                    ->default('alpha'),
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('latitude')
                    ->label('Latitude')
                    ->numeric(),
                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pegawai.nama')
                    ->label('Nama Pegawai')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pegawai.nip')
                    ->label('NIP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('jam_masuk')
                    ->label('Jam Masuk')
                    ->time('H:i')
                    ->badge()
                    ->color(fn ($record) => $record->is_late_check_in ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('jam_keluar')
                    ->label('Jam Keluar')
                    ->time('H:i')
                    ->badge()
                    ->color(fn ($record) => $record->is_late_check_out ? 'danger' : 'success'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'hadir',
                        'warning' => 'izin',
                        'danger' => 'alpha',
                        'primary' => 'sakit',
                    ]),
                Tables\Columns\IconColumn::make('is_late_check_in')
                    ->label('Telat Masuk')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),
                Tables\Columns\IconColumn::make('is_late_check_out')
                    ->label('Telat Pulang')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-circle')
                    ->falseIcon('heroicon-o-check-circle')
                    ->trueColor('danger')
                    ->falseColor('success'),
                Tables\Columns\TextColumn::make('late_duration_minutes')
                    ->label('Total Telat (Menit)')
                    ->badge()
                    ->color('danger')
                    ->default('-'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'hadir' => 'Hadir',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'alpha' => 'Alpha',
                    ]),
                Tables\Filters\Filter::make('terlambat')
                    ->label('Terlambat')
                    ->query(fn ($query) => $query->where(function($q) {
                        $q->where('is_late_check_in', true)
                          ->orWhere('is_late_check_out', true);
                    })),
                Tables\Filters\Filter::make('tepat_waktu')
                    ->label('Tepat Waktu')
                    ->query(fn ($query) => $query->where('is_late_check_in', false)
                        ->where('is_late_check_out', false)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('tanggal', 'desc');
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
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }
    
    public static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\LaporanPresensi::class,
        ];
    }
}