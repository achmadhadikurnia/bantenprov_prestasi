<?php

Route::group(['prefix' => 'api/prestasi', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@index',
        'create'    => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@create',
        'store'     => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@store',
        'show'      => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@show',
        'edit'      => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@edit',
        'update'    => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@update',
        'destroy'   => 'Bantenprov\Prestasi\Http\Controllers\PrestasiController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('prestasi.index');
    Route::get('/create',       $controllers->create)->name('prestasi.create');
    Route::post('/',            $controllers->store)->name('prestasi.store');
    Route::get('/{id}',         $controllers->show)->name('prestasi.show');
    Route::get('/{id}/edit',    $controllers->edit)->name('prestasi.edit');
    Route::put('/{id}',         $controllers->update)->name('prestasi.update');
    Route::delete('/{id}',      $controllers->destroy)->name('prestasi.destroy');
});
