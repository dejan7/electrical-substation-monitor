<?php

Route::get("/measurement/{interval}/{location_id}/{parameters}", "MeasurementController@getData");
Route::post("/measurement", "MeasurementController@listener");

Route::post("/query", "QueriesController@getData");