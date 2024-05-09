<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LagerTyp extends Model
{
	use HasFactory,
		SoftDeletes;

	protected $table = 'lagertypen';

	protected $primaryKey = 'lagertyp_id';

	protected $fillable = [
		'lagertyp_id',
		'name',
		'platz',
	];
}
